<?php

namespace App\Actions\Mover;

use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Activos\Ticker;
use App\Models\Posiciones\Posicion;

class AjustarMetaEnStoneXAction extends Base
{
    public function execute()
    {
        $broker = Broker::bySigla('PPI');

        $activo = Ticker::byName('FB')->activo;

        $posiciones = Posicion::abiertas()
            ->where('activo_id', $activo->id)
            ->where('broker_id', $broker->id)
            ->where('fecha_apertura', '>=', '2022-02-10')
            ->where('fecha_apertura', '<=', '2022-02-16')
            ->get();

        foreach($posiciones as $posicion)
        {
            $posicion->cantidad = $posicion->cantidad / 8;

            $posicion->save();
        }
    }
}