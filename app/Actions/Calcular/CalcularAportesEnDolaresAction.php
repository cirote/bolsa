<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Movimientos\Deposito;

class CalcularAportesEnDolaresAction
{
    static function do()
    {
        $depositos = (double) Deposito::sum('monto_en_dolares');

        return $depositos;
    }
}