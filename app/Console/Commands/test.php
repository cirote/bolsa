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

        \App\Actions\Mover\MoverStoneXAPpiAction::do();

        return 0;
    }
}
