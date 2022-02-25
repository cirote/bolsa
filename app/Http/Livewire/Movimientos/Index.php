<?php

namespace App\Http\Livewire\Movimientos;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Cuenta;
use App\Models\Movimientos\Movimiento;

class Index extends Component
{
    use Crud;

    public $cuenta;

    public $model_class = Movimiento::class;

    protected $rules = [
        'model.fecha_operacion' => 'required|string',
        'model.observaciones' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.movimientos.index', [
            'movimientos' => $this->cuenta->movimientos()->orderBy('fecha_operacion')->paginate($this->paginate)
        ]);
    }
}
