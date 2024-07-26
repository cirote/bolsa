<?php

namespace App\Http\Livewire\Broker;

use Livewire\Component;
use App\Models\Broker;

class Index extends Component
{
    use \Cirote\Ui\Traits\Crud;

    public $model_class = Broker::class;

    public $sort_by = 'sigla';

    public $sort_order = 'asc';

    protected $rules = [
        'model.sigla' => 'required|string|min:2|max:10',
        'model.nombre' => 'required|string|min:3|max:100'
    ];

    public function render()
    {
        return view('livewire.broker.index', [
            'brokers' => Broker::orderBy($this->sort_by, strtoupper($this->sort_order))
                ->paginate($this->paginate)
        ]);
    }
}
