<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Movimientos\Extraccion;

class CalcularRetirosEnDolaresAction
{
    static function do(Carbon $fecha = null)
    {
        if (! $fecha)
        {
            $fecha = Carbon::now();
        }

        $retiros = (double) Extraccion::where('fecha_operacion', '<=', $fecha)
            ->sum('monto_en_dolares');

        return -$retiros;
    }
}