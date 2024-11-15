<?php

namespace App\Http\Livewire\Seguimientos;

use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Seguimientos\Seguimiento;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    use \App\Traits\Trading;

    public $model_class = Seguimiento::class;

    protected $rules = [
        'model.activo_id'   => 'required|exists:activos,id',
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

    protected $messages = [
        'model.activo_id.numeric' => 'Debe elegir una opción',
        'model.tipo.string'       => 'Debe elegir una opción',
    ];

    public function render()
    {
        return view('livewire.seguimientos.index', [
            'seguimientos' => Seguimiento::with('activo')->paginate($this->paginate)
        ]);
    }

    public function actualizar_precio_inicial()
    {
        if ($ticker = $this->model->activo->tickerRefDolar)
        {
            if ($ticker = $this->model->activo->tickerRefDolar)
            {
                $this->model->base_1 = $this->actualizar_precio($ticker->ticker, $this->model->fecha_1, $this->model->base_1);
            }
        }
    }

    public function actualizar_precio_final()
    {
        if ($ticker = $this->model->activo->tickerRefDolar)
        {
            $this->model->base_2 = $this->actualizar_precio($ticker->ticker, $this->model->fecha_2, $this->model->base_2);
        }
    }

    protected function actualizar_precio(String $ticker, Carbon $fecha, $valor_actual)
    {
        $datos = \App\Apis\PythonFinanceApi::obtenerDatosCotizacion($ticker, $fecha); 

        if (isset($datos['cierre_ajustado']))
        {
            $ajuste = $datos['cierre_ajustado'] - $datos['cierre'];

            return round($datos['minimo'] + $ajuste, 2);
        }

        return $valor_actual;
    }
}
