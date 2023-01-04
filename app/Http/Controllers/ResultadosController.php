<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contables\Resultado;

class ResultadosController extends Controller
{
    public function index()
    {
        return view('resultados.index');
    }

    public function show(Resultado $resultado)
    {
        return view('resultados.show')->with('resultado', $resultado);
    }
}
