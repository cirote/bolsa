<?php

namespace App\Http\Livewire\Grillas;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Activos\Activo;

class Index extends Component
{
    use Crud;

    public $model_class = Activo::class;

    public $activo;

    protected $rules = [
        'model.simbolo' => 'required|string',
        'model.denominacion' => 'required|string|min:3|max:500'
    ];

    public function mount($activo)
    {
        $this->activo = $activo;
    }

    public function render()
    {
        return view('livewire.grillas.index', [
            'activos' => Activo::paginate($this->paginate)
        ]);
    }
}
