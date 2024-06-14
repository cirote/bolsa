<?php

namespace App\Http\Livewire\Seguimientos;

use Livewire\Component;
use App\Models\Seguimientos\Seguimiento;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = Seguimiento::class;

    protected $rules = [
        'model.activo_id' => 'required|integer',
        'model.fecha_1'   => 'date',
        'model.fecha_2'   => 'date'
    ];

    public function render()
    {
        return view('livewire.seguimientos.index', [
            'seguimientos' => Seguimiento::with('activo')->paginate($this->paginate)
        ]);
    }
}
