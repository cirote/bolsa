<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seguimientos\Seguimiento;

class RecomendacionesController extends Controller
{
    public function index()
    {
        $comprar = [];

        $vender = [];

        foreach(Seguimiento::all() as $seguimiento)
        {
            if (in_array($seguimiento->accion, ['Vender', 'Lanzar CALL']))
            {
                $vender[] = $seguimiento;
            }

            elseif (in_array($seguimiento->accion, ['Comprar', 'Lanzar PUT']))
            {
                $comprar[] = $seguimiento;
            }
        }

        return view('recomendaciones', [
            'comprar' => $comprar,
            'vender'  => $vender
        ]);
    }
}
