<?php

namespace App\Actions\Cuentas;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Cuenta;

class CalcularSaldosAction
{
    static public function do()
    {
        return (new static())->execute();
    }

    protected function execute()
    {
        $saldo = 0;

        foreach(Cuenta::bySigla('SX')->movimientos()->orderBy('fecha_operacion')->get() as $movimiento)
        {
            $saldo += $movimiento->monto;

            $movimiento->saldo = $saldo;

            $movimiento->save();
        }
    }
}