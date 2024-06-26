<?php

namespace App\Http\Livewire\Movimientos;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Cirote\Ui\Traits\Crud;
use App\Models\Cuenta;
use App\Models\Movimientos\Movimiento;

class Index extends Component
{
    use Crud;

    public $cuenta;

    public $anio;

    public $mes;

    public $model_class = Movimiento::class;

    protected $rules = [
        'model.fecha_operacion'   => 'required|string',
        'model.fecha_liquidacion' => 'required|string',
        'model.observaciones'     => 'required|string|min:3|max:500',
        'model.numero_operacion'  => 'required|numeric|min:3|max:500',
        'model.cantidad'          => 'numeric',
        'model.numero_boleto'     => 'numeric',
        'model.monto_en_dolares' => 'required|numeric|min:0',
    ];

    public function mount() 
    {  
        $this->anio = Carbon::now()->year();

        $this->mes = Carbon::now()->month();

        $this->anio = 2022;

        $this->mes = 1;
    }

    public function render()
    {
        $inicio = Carbon::create($this->anio, 1, 1);

        $fin = Carbon::create($this->anio, 12, 1)->addMonth(1);

        $this->cuenta->calcular_saldos();

        return view('livewire.movimientos.index', [
            'movimientos' => $this->cuenta
                ->movimientos()
                // ->where('fecha_operacion', '>=', $inicio)
                // ->where('fecha_operacion', '<', $fin)
                ->orderBy('fecha_operacion')
                ->paginate($this->paginate)
        ]);
    }
}
