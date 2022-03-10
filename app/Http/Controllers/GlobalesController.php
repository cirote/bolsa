<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalesController extends Controller
{
    public function index()
    {
        return view('globales.index');
    }
}
