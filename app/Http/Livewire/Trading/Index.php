<?php

namespace App\Http\Livewire\Trading;

use App\Models\Activos\Activo;
use Livewire\Component;

class Index extends Component
{
    use \Cirote\Ui\Traits\Ordenable;

    use \App\Traits\Trading;

    protected $activos;

    public function mount()
    {
        $this->sort_by = 'simbolo'; 
    }

    public function render()
    {
        if (! $this->activos) 
        {
            $this->activos = Activo::conStock();
//                ->mountwith('grillas')
  //              ->with('seguimientos');
        }

        $this->activos = ($this->sort_order == 'asc')
            ? $this->activos->sortBy($this->sort_by)
            : $this->activos->sortByDesc($this->sort_by);

        return view('livewire.trading.index', [
            'activos' => $this->activos
        ]);
    }
}
