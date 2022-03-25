<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Posiciones\Posicion;
use App\Models\Posiciones\Movimiento;
use App\Models\Movimientos\Movimiento as Operacion;
use App\Config\Constantes as Config;

class CalcularMontoInvertidoEnDolaresAction
{
    static function do(Carbon $fecha = null)
    {
        if (! $fecha)
        {
            $fecha = Carbon::now();
        }

        $inversion = 0;

        $posiciones_abiertas = Posicion::conResultados()
            ->where('fecha_apertura', '<=', $fecha)
            ->where('estado', 'Abierta')
            ->get();

        foreach($posiciones_abiertas as $posicion)
        {
            $inversion += $posicion->movimientos_sum_monto_parcial_en_dolares;
        }

        $posiciones_cerradas = Posicion::with('movimientos')
            ->where('estado', 'Cerrada')
            ->where('fecha_apertura', '<=', $fecha)
            ->where('fecha_cierre', '>', $fecha)
            ->get();

        foreach($posiciones_cerradas as $posicion)
        {
            $fecha = $posicion->movimientos()
                ->join(Config::PREFIJO . Config::MOVIMIENTOS, Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES . '.movimiento_id', '=', Config::PREFIJO . Config::MOVIMIENTOS . '.id')
                ->select(Config::PREFIJO . Config::MOVIMIENTOS . '.fecha_operacion')
                ->orderBy('fecha_operacion', 'DESC')
                ->first();

            $fecha = $fecha->fecha_operacion;

            $movimientos = $posicion->movimientos()
            ->join(Config::PREFIJO . Config::MOVIMIENTOS, Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES . '.movimiento_id', '=', Config::PREFIJO . Config::MOVIMIENTOS . '.id')
            ->select(Config::PREFIJO . Config::MOVIMIENTOS . '.fecha_operacion', Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES . '.*')
            ->where('fecha_operacion', '!=', $fecha)
            ->get();

            foreach($movimientos as $movimiento)
            {
                $inversion += $posicion->monto_parcial_en_dolares;    
            }
        }

        return - $inversion;
    }
}