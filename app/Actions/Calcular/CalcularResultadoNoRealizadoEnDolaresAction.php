<?php

namespace App\Actions\Calcular;

use App\Models\Operaciones\Operacion; 
use App\Models\Activos\Activo;

class CalcularResultadoNoRealizadoEnDolaresAction
{
    static function do()
    {
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

        return $activos->sum('resultadosNoRealizados');
    }
}