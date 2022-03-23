<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Movimientos\Deposito;
use App\Models\Movimientos\Extraccion;

class CalcularTIRActualAction
{
    static function do()
    {
        $depositos = Deposito::orderBy('fecha_operacion')->get();

        $retiros = Extraccion::orderBy('fecha_operacion')->get();

        $transacciones = [];

        foreach($depositos as $deposito)
        {
            $transacciones[] = [
                'fecha'    => $deposito->fecha_operacion,
                'cantidad' => $deposito->monto_en_dolares
            ];
        }

        foreach($retiros as $retiro)
        {
            $transacciones[] = [
                'fecha'    => $retiro->fecha_operacion,
                'cantidad' => $retiro->monto_en_dolares
            ];
        }

        $transacciones[] = [
            'fecha'    => Carbon::now(),
            'cantidad' => -155000
        ];

        return \App\Actions\Calcular\CalcularTIRAction::do($transacciones);
    }
}