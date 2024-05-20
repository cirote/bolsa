<?php

namespace App\Http\Livewire\Grillas;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = \App\Models\Seguimientos\Grilla::class;

    protected $rules = [
        'model.activo_id' => 'required|integer',
        'model.fecha_inicial' => 'required|date',
    ];

    public function initial_values()
    {
        $this->model->fecha_inicial = Carbon::Now(); 
    }

    public function render()
    {
        return view('livewire.grillas.index', [
            'grillas' => $this->model_class::paginate($this->paginate)
        ]);
    }
}
