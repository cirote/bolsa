<?php

namespace App\Actions\Mover;

use App\Models\Broker;
use App\Models\Activos\Ticker;

class MoverBellAStoneXAction extends Base
{
    public function execute()
    {
        $this->mover(
            Broker::bySigla('BELL'),
            Broker::bySigla('SX'),
            Ticker::byName('PBR')->activo
        );
    }
}