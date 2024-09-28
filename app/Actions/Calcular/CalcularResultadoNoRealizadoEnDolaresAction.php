<?php

namespace App\Actions\Calcular;

use App\Models\Activos\Activo;
use App\Models\Operaciones\Operacion;

class CalcularResultadoNoRealizadoEnDolaresAction
{
    static function do()
    {
        $activos_con_movimientos = Operacion::query()
            ->pluck('activo_id')
            ->unique();

        $activos = Activo::whereIn('id', $activos_con_movimientos)
            ->get();

        return $activos->sum('resultadosNoRealizados');
    }
}