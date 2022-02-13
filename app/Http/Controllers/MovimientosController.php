<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\ImportarDatosDeStoneXAction as Importador;

class MovimientosController extends Controller
{
    public function index()
    {
        Importador::do('transactions-17670277-20220213-103026.csv');

        return view('broker.index');
    }
}
