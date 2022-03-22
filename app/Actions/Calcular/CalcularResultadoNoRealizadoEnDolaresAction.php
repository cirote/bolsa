<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Posiciones\General;

class CalcularResultadoNoRealizadoEnDolaresAction
{
    static function do()
    {
        $resultado = 0;

        foreach(General::with('activo', 'posiciones')->conCantidad()->get() as $posicion_global)
        {
            $resultado += $posicion_global->resultado;
        }

        return $resultado;
    }
}