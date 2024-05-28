<?php

namespace App\Http\Livewire\Grillas;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Seguimientos\Grilla;
use App\Models\Seguimientos\Banda;

class Bandas extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = Banda::class;

    public $grilla;

    protected $rules = [
        'model.grilla_id' => 'required|integer',
        'model.fecha_operacion' => 'required|date',
        'model.precio_operacion' => 'required|numeric',
        'model.precio' => 'required|numeric',
        'model.monto' => 'required|numeric',
        'model.cantidad' => 'required|integer',
        'model.estado' => 'required|boolean'
    ];

    public function initial_values()
    {
        $this->model->fecha_operacion = Carbon::Now()->format('Y-m-d'); 
        $this->model->grilla_id = $this->grilla->id;
        $this->model->precio_operacion = 0;
        $this->model->estado = false;
    }

    public function mount(Grilla $grilla)
    {
        $this->grilla = $grilla;
    }

    public function render()
    {
        return view('livewire.grillas.bandas', [
            'activo'  => $this->grilla->activo,
            'bandas' => $this->grilla->bandas()
                ->selectRaw("*,  {$this->grilla->activo->cotizacion} as precio_activo")
                ->conLimites()
                ->orderBy('ac_bandas.precio', 'DESC')
                ->paginate($this->paginate)
        ]);
    }

    public function activar($id)
    {
        $this->grilla->bandas()
            ->where('estado', true)
            ->update(['estado' => false]);

        $this->grilla->bandas()
            ->where('id', $id)
            ->update(['estado' => true]);
    }
}
