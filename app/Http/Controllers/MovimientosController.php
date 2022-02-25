<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\ImportarDatosDeStoneXAction as Importador;
use App\Actions\ImputarMovimientosOriginalesEnPosicionesAction as Imputador;

class MovimientosController extends Controller
{
    public function index()
    {
        Importador::do('transactions-17670277-20220224-125600.csv');

        return view('movimientos.index');
    }

    public function index2()
    {
        Importador::do('transactions-17670277-20220224-125600.csv');

        Imputador::do();

        return view('broker.index');
    }
}