<?php

namespace App\Http\Livewire\Estados;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Contables\Estado;

class Index extends Component
{
    use Crud;

    public $model_class = Seguimiento::class;

    protected $rules = [
        'model.fecha_1' => 'required|string',
        'model.fecha_2' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.estados.index', [
            'estados' => Estado::orderBy('fecha', 'DESC')->paginate($this->paginate)
        ]);
    }
}
