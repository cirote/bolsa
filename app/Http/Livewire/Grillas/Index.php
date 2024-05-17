<?php

namespace App\Http\Livewire\Grillas;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Activos\Activo;
use App\Models\Activos\Ticker;
use App\Models\Seguimientos\Grilla;

class Index extends Component
{
    use Crud;

    public $model_class = Grilla::class;

    public $activo;

    public $simbolo;

    public $denominacion;

    protected $rules = [
        'model.activo_id' => 'required|date',
        'model.fecha_inicial' => 'required|date'
    ];

    public function validar_simbolo($propertyNam)
    {
        $campo = str_replace('', '', $propertyNam);

        if ($ticker = Ticker::byName($this->$campo))
        {
            $this->model->activo_id = $ticker->activo->id;

            $this->denominacion = $ticker->activo->denominacion;
        }

        else
        {
            $this->denominacion = 'Activo inexistente';
        }
    }

    public function initial_values()
    {
        $this->model->fecha_inicial = Carbon::Now(); 
    }

    public function mount($grilla)
    {
        $this->activo = $grilla;
    }

    public function render()
    {
        return view('livewire.grillas.index', [
            'grillas' => Grilla::paginate($this->paginate)
        ]);
    }
}
