<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activos\Activo;
use App\Models\Seguimientos\Grilla;

class GrillasController extends Controller
{
    public function index(Grilla $grilla)
    {
        return view('grillas.index', ['grilla' => $grilla]);
    }
}
