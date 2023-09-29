<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activos\Activo;


class BandasController extends Controller
{
    public function index(Activo $activo)
    {
        return view('bandas.index', ['activo' => $activo]);
    }
}
