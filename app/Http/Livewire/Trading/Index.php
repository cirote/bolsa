<?php

namespace App\Http\Livewire\Trading;

use App\Models\Activos\Activo;
use App\Models\Operaciones\Operacion; 
use Livewire\Component;

class Index extends Component
{
    public function trading(Activo $activo)
    {
        return redirect()->route('trading.activo', ['activo' => $activo]);
    }

    public function render()
    {
        $activos_validos = Operacion::query()
            ->select('activo_id')
            ->distinct()
            ->get()
            ->pluck('activo_id');

        $activos = Activo::whereIn('id', $activos_validos);

        $activos->orderBy('denominacion');

        $activos = $activos->get();

        $activos = $activos->filter(function ($activo) 
        {
            return $activo->stock != 0;
        });

        return view('livewire.trading.index', compact('activos'));
    }
}
