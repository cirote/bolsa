<?php

namespace App\Http\Controllers;

use App\Models\Activos\Activo;
use App\Models\Seguimientos\Seguimiento;
use App\Models\Seguimientos\Grilla;

class RecomendacionesController extends Controller
{
    public function index()
    {
        $activos = Activo::conStock()->filter(function ($activo) 
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
