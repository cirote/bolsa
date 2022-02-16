<?php

namespace App\Http\Livewire\Posiciones;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Movimientos\Posicion;

class Index extends Component
{
    use Crud;

    public $model_class = Posicion::class;

    protected $rules = [
        'model.fecha_apertura' => 'required|string',
        'model.tipo' => 'required|string|min:3|max:500',
        'model.estado' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.posiciones.index', [
            'posiciones' => Posicion::paginate($this->paginate)
        ]);
    }
}
