<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        return 0;
    }
}
