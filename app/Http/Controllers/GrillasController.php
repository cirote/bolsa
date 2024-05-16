<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activos\Activo;


class GrillasController extends Controller
{
    public function index(Activo $activo)
    {
        return view('grillas.index', ['activo' => $activo]);
    }
}
