<?php

namespace App\Actions\Cuentas;

use App\Models\Cuenta;
use App\Models\Movimientos\Movimiento;

class CalcularSaldosAction
{
    static public function do(Cuenta $cuenta = null)
    {
        return (new static())->execute($cuenta);
    }

    protected function execute(Cuenta $cuenta = null)
    {
        if ($cuenta)
        {
            $this->cuenta($cuenta);
        }

        else
        {
            foreach(Cuenta::all() as $cuenta)
            {
                $this->cuenta($cuenta);
            }
        }
    }

    protected function cuenta($cuenta)
    {
        $saldo_original = 0;

        $saldo_pesos = 0;

        $saldo_dolares = 0;

        $movimientos = Movimiento::where('cuenta_id', $cuenta->id)
            ->orderBy('fecha_operacion')
            ->orderBy('id');

        foreach($movimientos->cursor() as $movimiento)
        {

            $saldo_original += $movimiento->monto_en_moneda_original;

            $saldo_dolares += $movimiento->monto_en_dolares;

            $saldo_pesos += $movimiento->monto_en_pesos;

            $movimiento->fill([
                'saldo_calculado_en_moneda_original' => $saldo_original,
                'saldo_en_dolares' => $saldo_dolares,
                'saldo_en_pesos' => $saldo_pesos
            ]);

            // echo "ID: " . $movimiento->id . ", Fecha: " . $movimiento->fecha_operacion->format('Y/m/d') . ", Monto: " . $movimiento->monto_en_dolares . ", Saldo: " . $saldo_dolares . "<br>";

            // if ($movimiento->id = 3099)
            //     dd($movimiento);

            $movimiento->save();
        }

        // dd('');
    }
}