<?php

namespace App\Actions\Mover;

use App\Models\Broker;

class MoverIolAPpiAction extends Base
{
    public function execute()
    {
        $this->mover_varios(
            Broker::bySigla('IOL'),
            Broker::bySigla('SX'),
            ['TXAR', 'YPF']
        );

        /*
            El movimiento real de PBR fue de IOL a PPI y despues a SX
            Aquí se hace de esta maneera por simplicidad
        */
    }
}