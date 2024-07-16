<?php

namespace App\Http\Livewire\Grillas;

use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Activos\Activo;
use App\Models\Seguimientos\Grilla;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = Grilla::class;

    protected $rules = [
        'model.activo_id' => 'required|integer',
        'model.fecha_inicial' => 'required|date',
        'model.precio_activacion' => 'nullable|numeric|min:0',
    ];

    public function trading(Activo $activo)
    {
        return redirect()->route('trading.activo', ['activo' => $activo]);
    }

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

    public function activar(Grilla $grilla)
    {
        $grilla->precio_activacion = null;

        $grilla->save();
    }

    public function ver_bandas(Grilla $grilla)
    {
        return redirect()->route('grillas.bandas', 
            [
                'header' => 'Bandas de precios',
                'grilla' => $grilla
            ]
        );
    }
}
