<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;

class MovimientosController extends Controller
{
    public function index()
    {
        return view('movimientos.index')->with('cuenta', Cuenta::first());
    }

    public function show(Cuenta $cuenta)
    {
        return view('movimientos.index')->with('cuenta', $cuenta);
    }
}
