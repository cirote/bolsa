<?php

namespace App\Http\Livewire\Activos;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Activos\Activo;

class Index extends Component
{
    use Crud;

    public $model_class = Activo::class;

    protected $rules = [
        'model.simbolo' => 'required|string',
        'model.denominacion' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.activos.index', [
            'activos' => Activo::paginate($this->paginate)
        ]);
    }
}
