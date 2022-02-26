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
        foreach(Cuenta::all() as $cuenta)
        {
            $this->cuenta($cuenta);
        }
    }

    protected function cuenta($cuenta)
    {
        $saldo = 0;

        foreach($cuenta->movimientos()->orderBy('fecha_operacion')->get() as $movimiento)
        {
            $saldo += $movimiento->monto;

            $movimiento->saldo = $saldo;

            $movimiento->save();
        }
    }
}