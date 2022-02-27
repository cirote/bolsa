<?php

namespace App\Http\Livewire\Cuentas;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Cuenta;

class Index extends Component
{
    use Crud;

    public $model_class = Cuenta::class;

    protected $rules = [
        'model.sigla' => 'required|string',
        'model.nombre' => 'required|string|min:3|max:500'
    ];

    public function ver_cuenta(Cuenta $cuenta)
    {
        return redirect()->route('movimientos.show', ['cuenta' => $cuenta]);
    }

    public function render()
    {
        return view('livewire.cuentas.index', [
            'cuentas' => Cuenta::conSaldos()->paginate($this->paginate)
        ]);
    }
}
