<?php

namespace App\Http\Livewire\Broker;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Broker;

class Index extends Component
{
    use Crud;

    public $model_class = Broker::class;

    public $nombre = "Esteban";
    protected $rules = [

        'model.sigla' => 'required|string|min:6',

        'model.nombre' => 'required|string|min:6|max:500',

    ];
    public function render()
    {
        return view('livewire.broker.index', [
            'brokers' => Broker::paginate($this->paginate)
        ]);
    }
}
