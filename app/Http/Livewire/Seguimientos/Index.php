<?php

namespace App\Http\Livewire\Seguimientos;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\Seguimientos\Seguimiento;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    use \App\Traits\Trading;

    public $model_class = Seguimiento::class;

    protected $rules = [
        'model.activo_id'   => 'required|integer',
        'model.fecha_1'     => 'date',
        'model.fecha_2'     => 'date',
        'model.base_1'      => 'nullable|numeric|min:0',
        'model.base_2'      => 'nullable|numeric|min:0',
        'model.amplitud'    => 'nullable|numeric|min:0',
        'model.piso'        => 'nullable|numeric|min:0',
        'model.techo'       => 'nullable|numeric|min:0',
        'model.tipo'        => 'string',
        'model.comentarios' => 'nullable|string',
        'model.activo_id'   => 'numeric'
    ];

    public function initial_values()
    {
        // $this->model->fecha_1 = Carbon::Now()->format('Y-m-d'); 
        // $this->model->fecha_2 = Carbon::Now()->format('Y-m-d'); 
    }

    public function render()
    {
        return view('livewire.seguimientos.index', [
            'seguimientos' => Seguimiento::with('activo')->paginate($this->paginate)
        ]);
    }
}
