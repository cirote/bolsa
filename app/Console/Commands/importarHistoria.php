<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class importarHistoria extends Command
{
    protected $signature = 'populate:historia';

    protected $description = 'Importa datos de movimientos historicos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //  Limpiar tablas de datos

        Schema::disableForeignKeyConstraints();

        \App\Models\Posiciones\Movimiento::truncate();

        \App\Models\Posiciones\Posicion::truncate();

        \App\Models\Movimientos\Movimiento::truncate();

        Schema::enableForeignKeyConstraints();

        //  IOL

        \App\Actions\Importar\ImportarDatosDeIolAction::do();

        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        \App\Actions\Mover\MoverIolAStoneXAction::do();

        \App\Actions\Mover\MoverIolAPpiAction::do();

        //  BELL

        \App\Actions\Importar\ImportarDatosDeBellAction::do();

        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        \App\Actions\Mover\MoverBellAStoneXAction::do();

        \App\Actions\Mover\MoverBellAPpiAction::do();

        //  STONE X

        \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20220307-030041 - corregido hasta 7-3-2022.csv');

        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        \App\Actions\Mover\MoverStoneXAPpiAction::do();

        //  PPI

        \App\Actions\Importar\ImportarDatosDePpiAction::do();

        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        \App\Actions\Mover\AjustarMetaEnStoneXAction::do();

        //  STONE X

        \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20220407-083319.csv');

        \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20220421-025930.csv');

        \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20221222-124407.csv');

        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        \App\Actions\Cuentas\CalcularSaldosAction::do();
        
        return 0;
    }
}
