<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use App\Models\Activos\Activo;
use App\Models\Operaciones\Operacion;

class CalcularMontoInvertidoEnDolaresAction
{
    /*
        Falta filtrar por fecha
    */

    static function do(Carbon $fecha = null)
    {
        if (! $fecha)
        {
            $fecha = Carbon::now();
        }

        $activos_con_movimientos = Operacion::query()
            ->pluck('activo_id')
            ->unique();

        $activos = Activo::whereIn('id', $activos_con_movimientos)
            ->get();

        return $activos->sum('inversion');
   }
}