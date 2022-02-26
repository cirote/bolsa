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
        $saldo_original = 0;

        $saldo_pesos = 0;

        $saldo_dolares = 0;

        foreach($cuenta->movimientos()->orderBy('fecha_operacion')->get() as $movimiento)
        {
            $saldo_original += $movimiento->monto_en_moneda_original;

            $saldo_dolares += $movimiento->monto_en_dolares;

            $saldo_pesos += $movimiento->monto_en_pesos;

            $movimiento->fill([
                'saldo_calculado_en_moneda_original' => $saldo_original,
                'saldo_en_dolares' => $saldo_dolares,
                'saldo_en_pesos' => $saldo_pesos
            ]);

            $movimiento->save();
        }
    }
}