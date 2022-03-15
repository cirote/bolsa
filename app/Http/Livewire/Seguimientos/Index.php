<?php

namespace App\Http\Livewire\Seguimientos;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Seguimientos\Seguimiento;

class Index extends Component
{
    use Crud;

    public $model_class = Seguimiento::class;

    protected $rules = [
        'model.fecha_1' => 'required|string',
        'model.fecha_2' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.seguimientos.index', [
            'seguimientos' => Seguimiento::with('activo')->paginate($this->paginate)
        ]);
    }
}
