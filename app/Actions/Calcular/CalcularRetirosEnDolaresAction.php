<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Movimientos\Extraccion;

class CalcularRetirosEnDolaresAction
{
    static function do()
    {
        $retiros = (double) Extraccion::sum('monto_en_dolares');

        return -$retiros;
    }
}