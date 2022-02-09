<?php

namespace App\Http\Livewire\Broker;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Broker;

class Index extends Component
{
    use Crud;

    public $model_class = Broker::class;

    protected $rules = [
        'model.sigla' => 'required|string',
        'model.nombre' => 'required|string|min:3|max:500'
    ];

    public function render()
    {
        return view('livewire.broker.index', [
            'brokers' => Broker::paginate($this->paginate)
        ]);
    }
}
