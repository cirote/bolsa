<?php

namespace App\Http\Livewire\Operaciones;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Operaciones\Operacion;

class Index extends Component
{
    use Crud;

    public $model_class = Operacion::class;

    public $sort_by = 'id';

    public $sort_order = 'DESC';

    protected $rules = [
        'model.activo_id' => 'nullable',
        'model.type' => 'nullable',
        'model.observaciones' => 'nullable|string'
    ];

    public function render()
    {
        $operaciones = Operacion::conMonto()
            ->orderBy($this->sort_by, $this->sort_order);

        return view('livewire.operaciones.index', [
            'operaciones' => $operaciones
                ->paginate($this->paginate)
        ]);
    }
}
