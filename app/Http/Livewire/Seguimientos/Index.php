<?php

namespace App\Http\Livewire\Seguimientos;

use Livewire\Component;
use App\Models\Seguimientos\Seguimiento;
use App\Models\Activos\Activo;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = Seguimiento::class;

    protected $rules = [
        'model.activo_id' => 'required|integer',
        'model.fecha_1'   => 'date',
        'model.fecha_2'   => 'date',
        'model.base_1'    => 'numeric',
        'model.base_2'    => 'numeric',
        'model.amplitud'  => 'numeric',
        'model.piso'      => 'numeric',
        'model.techo'     => 'numeric',
        'model.tipo'      => 'string',
        'model.comentarios' => 'string',
        'model.activo_id' => 'numeric'
    ];

    public function trading(Activo $activo)
    {
        return redirect()->route('trading.index', ['activo' => $activo]);
    }

    public function render()
    {
        return view('livewire.seguimientos.index', [
            'seguimientos' => Seguimiento::with('activo')->paginate($this->paginate)
        ]);
    }
}
