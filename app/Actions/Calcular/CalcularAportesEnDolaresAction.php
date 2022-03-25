<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Movimientos\Deposito;

class CalcularAportesEnDolaresAction
{
    static function do(Carbon $fecha = null)
    {
        if (! $fecha)
        {
            $fecha = Carbon::now();
        }

        $depositos = (double) Deposito::where('fecha_operacion', '<=', $fecha)
            ->sum('monto_en_dolares');

        return $depositos;
    }
}