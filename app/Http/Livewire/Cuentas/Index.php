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

    public function render()
    {
        return view('livewire.cuentas.index', [
            'cuentas' => Cuenta::paginate($this->paginate)
        ]);
    }
}
