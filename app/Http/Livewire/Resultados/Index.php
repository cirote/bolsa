<?php

namespace App\Http\Livewire\Resultados;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Contables\Resultado;

class Index extends Component
{
    use Crud;

    public $model_class = Resultado::class;

    protected $rules = [
        'model.fecha_1' => 'required|string',
        'model.fecha_2' => 'required|string|min:3|max:500'
    ];

    public function ver_detalles(Resultado $resultado)
    {
        return redirect()->route('resultados.show', ['resultado' => $resultado]);
    }

    public function render()
    {
        return view('livewire.resultados.index', [
            'resultados' => Resultado::paginate($this->paginate)
        ]);
    }
}
