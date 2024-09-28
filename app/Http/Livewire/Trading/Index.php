<?php

namespace App\Http\Livewire\Trading;

use Livewire\Component;
use App\Models\Activos\Activo;
use App\Models\Operaciones\Operacion;

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
            $activos_con_movimientos = Operacion::query()
                ->pluck('activo_id')
                ->unique();

            $activos = Activo::with(['grillas', 'seguimientos', 'dividendos', 'compras', 'ventas', 'ticker', 'tickerRefDolar', 'tickerRefPesos'])
                ->whereIn('id', $activos_con_movimientos)
                ->get();

            $this->activos = $activos->filter(function ($activo) 
                {
                    return $activo->stock != 0;
                });
        }

        $this->activos = ($this->sort_order == 'asc')
            ? $this->activos->sortBy($this->sort_by)
            : $this->activos->sortByDesc($this->sort_by);

        return view('livewire.trading.index', [
            'activos' => $this->activos
        ]);
    }
}
