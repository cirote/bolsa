<?php

namespace App\Http\Livewire\Trading;

use App\Models\Activos\Activo;
use Livewire\Component;

class Index extends Component
{
    public Activo $activo;
    
    public function mount(Activo $activo)
    {
        $this->activo = $activo;
    }

    public function render()
    {
        return view('livewire.trading.index');
    }
}
