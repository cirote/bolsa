<?php

namespace App\Http\Livewire\Movimientos;

use Livewire\Component;

class Panel extends Component
{
    public function importar_stone()
    {
        \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20220224-125600.csv');
    }

    public function importar_ppi()
    {
        \App\Actions\Importar\ImportarDatosDePpiAction::do();
    }

    public function importar_iol()
    {
        \App\Actions\Importar\ImportarDatosDeIolAction::do();
    }

    public function importar_bell()
    {
        \App\Actions\Importar\ImportarDatosDeBellAction::do();
    }

    public function calcular_saldos()
    {
        \App\Actions\Cuentas\CalcularSaldosAction::do();
    }

    public function imputar_movimientos()
    {
        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();
    }

    public function render()
    {
        return view('livewire.movimientos.panel');
    }
}
