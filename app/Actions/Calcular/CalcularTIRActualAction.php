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

        $saldo_caja_en_dolares = \App\Actions\Calcular\CalcularSaldoDeCajaEnDolaresAction::do();
        
        $monto_invertido_en_dolares = \App\Actions\Calcular\CalcularMontoInvertidoEnDolaresAction::do();

        $ganancias_no_realizadas = \App\Actions\Calcular\CalcularResultadoNoRealizadoEnDolaresAction::do();

        $valor_inversiones = $monto_invertido_en_dolares + $ganancias_no_realizadas;

        $valor_actual = $saldo_caja_en_dolares + $valor_inversiones;

        $transacciones[] = [
            'fecha'    => Carbon::now(),
            'cantidad' => -$valor_actual
        ];

        return \App\Actions\Calcular\CalcularTIRAction::do($transacciones);
    }
}