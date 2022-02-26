<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//  use App\Actions\Importar\ImportarDatosDeStoneXAction as Importador;
use App\Actions\Importar\ImportarDatosDePpiAction as Importador;
use App\Actions\ImputarMovimientosOriginalesEnPosicionesAction as Imputador;
use App\Models\Cuenta;

class MovimientosController extends Controller
{
    public function index()
    {
        Importador::do();

        return view('movimientos.index')->with('cuenta', Cuenta::first());
    }

    public function show(Cuenta $cuenta)
    {
        Imputador::do();
        
        return view('movimientos.index')->with('cuenta', $cuenta);
    }

    public function index2()
    {
        Importador::do('transactions-17670277-20220224-125600.csv');

        Imputador::do();

        return view('broker.index');
    }
}
