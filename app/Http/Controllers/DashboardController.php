<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seguimientos\Seguimiento;

class DashboardController extends Controller
{
    public function index()
    {
        $comprar = [];

        $vender = [];

        foreach(Seguimiento::all() as $seguimiento)
        {
            if (in_array($seguimiento->accion, ['Vender', 'Lanzar PUT']))
            {
                $vender[] = $seguimiento;
            }

            elseif (in_array($seguimiento->accion, ['Comprar', 'Lanzar CALL']))
            {
                $comprar[] = $seguimiento;
            }
        }

        return view('dashboard', [
            'comprar' => $comprar,
            'vender'  => $vender
        ]);
    }
}
