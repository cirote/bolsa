<?php

namespace App\Http\Livewire\Trading;

use App\Models\Activos\Activo;
use Livewire\Component;

class Index extends Component
{
    use \App\Traits\Trading;
    
    public function render()
    {
        $activos = Activo::conStock();

        return view('livewire.trading.index', compact('activos'));
    }
}
