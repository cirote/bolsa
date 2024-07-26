<?php

namespace App\Http\Livewire\Broker;

use Livewire\Component;
use App\Models\Broker;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = Broker::class;

    protected $rules = [
        'model.sigla' => 'required|string|min:2|max:10',
        'model.nombre' => 'required|string|min:3|max:100'
    ];

    public function render()
    {
        return view('livewire.broker.index', [
            'brokers' => Broker::paginate($this->paginate)
        ]);
    }
}
