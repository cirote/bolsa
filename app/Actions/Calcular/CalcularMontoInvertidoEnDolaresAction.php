<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
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

        return Activo::conStock()->sum('inversion');
   }
}