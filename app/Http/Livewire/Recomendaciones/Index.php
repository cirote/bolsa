<?php

namespace App\Http\Livewire\Recomendaciones;

use Livewire\Component;
use App\Models\Activos\Activo;
use App\Models\Operaciones\Operacion;
use App\Models\Seguimientos\Seguimiento;
use App\Models\Seguimientos\Grilla;

class Index extends Component
{
    use \App\Traits\Trading;

    use \App\Traits\Bandas;
    
    public function render()
    {
        \App\Actions\Recomendaciones\FiltrarRecomendacionesAction::do();

        $activos_con_movimientos = Operacion::query()
            ->pluck('activo_id')
            ->unique();

        $activos = Activo::whereIn('id', $activos_con_movimientos)->get()->filter(function ($activo) 
        {
            return $activo->estado != '';
        });

        $seguimientos = Seguimiento::with('activo')->get()->filter(function ($activo) 
        {
            return $activo->estado != '';
        });

        $grillas = Grilla::all()->filter(function ($activo) 
        {
            return $activo->estado != '';
        });

        return view('recomendaciones', [
            'activos'       => $activos,
            'seguimientos'  => $seguimientos,
            'grillas'       => $grillas,
        ]);
    }
}
