<?php

namespace App\Http\Livewire\Movimientos;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Cirote\Ui\Traits\Crud;
use App\Models\Cuenta;
use App\Models\Movimientos\Movimiento;

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
        'model.numero_operacion'  => 'required|numeric|min:3|max:500',
        'model.cantidad'          => 'numeric',
        'model.numero_boleto'     => 'numeric',
        'model.monto_en_dolares' => 'required|numeric|min:0',
    ];

    public function mount() 
    {  
        $this->anio = Carbon::now()->year();

        $this->mes = Carbon::now()->month();

        $this->anio = 2022;

        $this->mes = 1;
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
