<?php

namespace App\Http\Livewire\Broker;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Models\Broker;

class Index extends Component
{
    use Crud;

    public $model_class = Broker::class;

    public function render()
    {
        return view('livewire.broker.index', [
            'brokers' => Broker::paginate($this->paginate)
        ]);
    }
}
