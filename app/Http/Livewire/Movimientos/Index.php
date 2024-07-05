<?php

namespace App\Http\Livewire\Movimientos;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Cirote\Ui\Traits\Crud;
use App\Models\Movimientos\Movimiento;
use App\Models\Operaciones\Operacion;

class Index extends Component
{
    use Crud;

    public $cuenta;

    public $anio;

    public $mes;

    public $sort_by = 'fecha_operacion';

    public $sort_order = 'ASC';

    public $model_class = Movimiento::class;

    protected $rules = [
        'model.fecha_operacion'   => 'required|string',
        'model.fecha_liquidacion' => 'required|string',
        'model.observaciones'     => 'required|string|min:3|max:500',
        'model.numero_operacion'  => 'nullable|numeric',
        'model.cantidad'          => 'nullable|numeric',
        'model.numero_boleto'     => 'nullable:numeric',
        'model.monto_en_dolares'  => 'required|numeric',
        'model.type'              => 'required|string',
    ];

    public function mount() 
    {  
        $this->anio = Carbon::now()->year();

        $this->mes = Carbon::now()->month();

        $this->anio = 2022;

        $this->mes = 1;
    }

    public function initial_values()
    {
        $this->model->fecha_operacion = Carbon::now();

        $this->model->fecha_liquidacion = Carbon::now();

        $this->model->type = '';
    }

    public function before_save()
    {
        $this->model->broker_id = $this->cuenta->broker_id;

        $this->model->cuenta_id = $this->cuenta->id;

        if (! $this->model->cantidad)
        {
            $this->model->cantidad = null;
        };
    }

    public function crear_operacion(Movimiento $movimiento)
    {
        $operacion = Operacion::create([
            'activo_id' => $movimiento->activo_id,
            'observaciones' => $movimiento->observaciones,
            'type' => str_replace('\Models\Movimientos', '\Models\Operaciones', $movimiento->type),
        ]);

        $movimiento->fill([
            'operacion_id' => $operacion->id,
            'operacion_principal' => true,
        ]);

        $movimiento->save();

        if ($this->selectedRows)
        {
            Movimiento::whereIn('id', $this->selectedRows)
                ->update(['operacion_id' => $operacion->id]);
        }

        $this->selectedRows = [];
    }

    public function render()
    {
        $inicio = Carbon::create($this->anio, 1, 1);

        $fin = Carbon::create($this->anio, 12, 1)->addMonth(1);

        $this->cuenta->calcular_saldos();

        $movimientos = $this->cuenta
            ->movimientos()
            // ->where('fecha_operacion', '>=', $inicio)
            // ->where('fecha_operacion', '<', $fin)
            ->orderBy($this->sort_by, $this->sort_order);

        if ($this->filtro)
        {
            $movimientos->where('observaciones', 'like', '%'. $this->filtro . '%')
                ->orWhere('numero_operacion', 'like', '%'. $this->filtro . '%')  ;
        }

        return view('livewire.movimientos.index', [
            'movimientos' => $movimientos
                ->paginate($this->paginate)
        ]);
    }
}
