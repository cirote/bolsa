<?php

namespace App\Http\Livewire\Operaciones;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Operaciones\Operacion;

class Index extends Component
{
    use Crud;

    public $model_class = Operacion::class;

    protected $rules = [
        'model.simbolo' => 'required|string',
        'model.denominacion' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.operaciones.index', [
            'operaciones' => Operacion::paginate($this->paginate)
        ]);
    }
}
