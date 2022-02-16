<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivosController extends Controller
{
    public function index()
    {
        return view('activos.index');
    }
}
