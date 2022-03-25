<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadosController extends Controller
{
    public function index()
    {
        return view('estados.index');
    }
}
