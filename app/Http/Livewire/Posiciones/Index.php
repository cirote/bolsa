<?php

namespace App\Http\Livewire\Posiciones;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Cirote\Ui\Traits\Crud;
use App\Models\Posiciones\Posicion;

class Index extends Component
{
    use Crud;

    public $model_class = Posicion::class;

    public $anio;

    public $mes;

    protected $rules = [
        'model.fecha_apertura' => 'required|string',
        'model.tipo' => 'required|string|min:3|max:500',
        'model.estado' => 'required|string|min:3|max:500'
    ];

    public function mount() 
    {  
        $this->paginate = 1000;

        $this->anio = Carbon::now()->year();

        $this->mes = Carbon::now()->month();

        $this->anio = 2022;

        $this->mes = 1;
    }

    public function render()
    {
        $inicio = Carbon::create($this->anio, 1, 1);

        $fin = Carbon::create($this->anio, 12, 1)->addMonth(1);

        return view('livewire.posiciones.index', [
            'posiciones' => Posicion::conResultados()
//                ->where('fecha_apertura', '>=', $inicio)
//                ->where('fecha_apertura', '<', $fin)
                ->orderBy('fecha_apertura', 'ASC')
                ->paginate($this->paginate)
        ]);
    }
}
