<?php

namespace App\Actions\Mover;

use App\Models\Broker;

class MoverIolAStoneXAction extends Base
{
    public function execute()
    {
        $this->mover_varios(
            Broker::bySigla('IOL'),
            Broker::bySigla('SX'),
            ['GD30', 'PBR', 'ITUB']
        );

        /*
            Los movimientos reales de PBR e ITUB fue de IOL a PPI y despues a SX
            Aquí se hace de esta maneera por simplicidad
        */
    }
}