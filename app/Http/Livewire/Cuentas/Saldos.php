<?php

namespace App\Http\Livewire\Cuentas;

use App\Models\Activos\Activo;
use Livewire\Component;

use App\Models\Cuenta;

class Saldos extends Component
{
    public function render()
    {
        $euro = Activo::where('denominacion', 'Euro')->first();

        $dolares = Activo::where('denominacion', 'Dolar Americano')->first();

        $argentinos = Activo::where('denominacion', 'Peso Argentino')->first();

        $cuentas = Cuenta::conSaldos()
            ->get()
            ->where('saldo', '>', 0);

        $enEuros = $cuentas->where('moneda_id', $euro->id);

        $enDolares = $cuentas->where('moneda_id', $dolares->id);

        $enArgentinos = $cuentas->where('moneda_id', $argentinos->id);

        return view('livewire.cuentas.saldos', [
            'cuentas' => $cuentas,
            'enEuros' => $enEuros,
            'enDolares' => $enDolares,
            'enArgentinos' => $enArgentinos,
        ]);
    }
}
