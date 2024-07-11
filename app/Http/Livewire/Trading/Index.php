<?php

namespace App\Http\Livewire\Trading;

use App\Models\Activos\Activo;
use App\Models\Operaciones\Compraventa;
use App\Models\Operaciones\Operacion;
use Livewire\Component;

class Index extends Component
{
    public Activo $activo;

    public $operacion_compra;

    public $operacion_venta;

    public function imputar_compra($operacion)
    {
        $this->operacion_compra = $operacion;
    }

    public function imputar_venta($operacion)
    {
        if ($this->operacion_compra)
        {   
            $operacion_compra = Operacion::find($this->operacion_compra);

            $operacion_venta = Operacion::find($operacion);

            Compraventa::create([
                'operacion_compra_id' => $operacion_compra->id,
                'operacion_venta_id' => $operacion_venta->id,
                'cantidad' => min($operacion_compra->saldo, $operacion_venta->saldo)
            ]);

            $this->operacion_compra = null;

            $this->activo->refresh();
        }
        
        else 
        {
            $this->operacion_venta = $operacion;
        }
    }

    public function mount(Activo $activo)
    {
        $this->activo = $activo;
    }

    public function render()
    {
        return view('livewire.trading.index');
    }
}
