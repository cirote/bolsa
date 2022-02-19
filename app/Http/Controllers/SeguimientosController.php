<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeguimientosController extends Controller
{
    public function index()
    {
        return view('seguimientos.index');
    }
}
