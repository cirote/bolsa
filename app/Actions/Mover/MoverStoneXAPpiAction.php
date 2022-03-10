<?php

namespace App\Actions\Mover;

use App\Models\Broker;
use App\Models\Activos\Ticker;

class MoverStoneXAPpiAction extends Base
{
    public function execute()
    {
        $this->mover(
            Broker::bySigla('SX'),
            Broker::bySigla('PPI'),
            Ticker::byName('PBR')->activo
        );
    }
}