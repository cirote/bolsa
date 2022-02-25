<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CuentasController extends Controller
{
    public function index()
    {
        return view('cuentas.index');
    }
}
