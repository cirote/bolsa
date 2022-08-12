<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Cuenta;
use App\Models\Activos\Moneda;

class CalcularSaldoDeCajaEnDolaresAction
{
    static function do(Carbon $fecha = null)
    {
        $saldo = 0;

        $moneda = Moneda::where('denominacion', 'like', 'Dolar Americano')->first();

        $cuentas = Cuenta::conSaldos($fecha)
            ->where('moneda_id', $moneda->id)
            ->whereIn('id', [9, 17])
            ->get();

        foreach($cuentas as $cuenta)
        {
            $saldo += $cuenta->saldo;
        }

        return $saldo;
    }
}