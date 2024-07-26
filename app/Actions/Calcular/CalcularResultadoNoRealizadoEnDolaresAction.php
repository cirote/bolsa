<?php

namespace App\Actions\Calcular;

use App\Models\Activos\Activo;

class CalcularResultadoNoRealizadoEnDolaresAction
{
    static function do()
    {
        return Activo::conStock()->sum('resultadosNoRealizados');
    }
}