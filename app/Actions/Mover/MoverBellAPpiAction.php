<?php

namespace App\Actions\Mover;

use App\Models\Broker;

class MoverBellAPpiAction extends Base
{
    public function execute()
    {
        $this->mover_varios(
            Broker::bySigla('BELL'),
            Broker::bySigla('PPI'),
            ['YPFD', 'GGAL', 'SUPV']
        );
    }
}