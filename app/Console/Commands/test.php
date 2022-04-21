<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class test extends Command
{
    protected $signature = 'test:do';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // \App\Actions\Importar\ImportarDatosDeIolAction::do();

        // \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        // \App\Actions\Mover\MoverIolAStoneXAction::do();

        // \App\Actions\Mover\MoverIolAPpiAction::do();

        // \App\Actions\Mover\MoverStoneXAPpiAction::do();

        \App\Actions\Importar\ImportarDatosDePpiAction::do('Movimientos 2022-04-07-09-12-37.xlsx');

        // \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        // \App\Actions\Mover\AjustarMetaEnStoneXAction::do();

        // \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20220421-025930.csv');

        // \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        return 0;
    }
}
