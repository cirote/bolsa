<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use App\Models\Operaciones\Operacion; 
use App\Models\Activos\Activo;

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

        $activos_validos = Operacion::query()
            ->select('activo_id')
            ->distinct()
            ->get()
            ->pluck('activo_id');

        $activos = Activo::whereIn('id', $activos_validos);

        $activos = $activos->get();

        $activos = $activos->filter(function ($activo) 
        {
            return $activo->stock != 0;
        });

        return $activos->sum('inversion');
   }
}