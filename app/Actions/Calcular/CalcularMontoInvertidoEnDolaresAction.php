<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Posiciones\General;

class CalcularMontoInvertidoEnDolaresAction
{
    static function do()
    {
        $inversion = 0;

        foreach(General::with('activo', 'posiciones')->conCantidad()->get() as $posicion_global)
        {
            $inversion += $posicion_global->inversion;
        }

        return - $inversion;
    }
}