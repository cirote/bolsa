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
        // \App\Actions\Importar\ImportarDatosDeStoneXAction::do('transactions-17670277-20220307-030041 - corregido hasta 7-3-2022.csv');

        // \App\Actions\Importar\ImportarDatosDeBellAction::do();

        \App\Actions\ImputarMovimientosOriginalesEnPosicionesAction::do();

        return 0;
    }
}
