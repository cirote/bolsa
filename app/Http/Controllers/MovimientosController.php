<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\ImportarDatosDeStoneXAction as Importador;
use App\Actions\ImputarMovimientosOriginalesEnPosicionesAction as Imputador;

class MovimientosController extends Controller
{
    public function index()
    {
        return view('movimientos.index');
    }

    public function index2()
    {
        Importador::do('transactions-17670277-20220213-103026.csv');

        Imputador::do();

        return view('broker.index');
    }
}
