<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosicionesController extends Controller
{
    public function index()
    {
        return view('posiciones.index');
    }

    public function corto_index()
    {
        return view('posiciones.corto.index');
    }
}
