<?php

namespace App\Actions\Mover;

use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Activos\Ticker;
use App\Models\Posiciones\Posicion;

abstract class Base
{
    static public function do()
    {
        return (new static())->execute();
    }

    abstract public function execute();

    protected function mover(Broker $broker_origen, Broker $broker_destino, Activo $activo, $cantidad = null)
    {
        foreach(Posicion::abiertas()->where('activo_id', $activo->id)->where('broker_id', $broker_origen->id)->get() as $posicion)
        {
            $posicion->broker_id = $broker_destino->id;

            $posicion->save();
        }
    }

    protected function mover_varios(Broker $broker_origen, Broker $broker_destino, $activos)
    {
        foreach($activos as $activo)
        {
            $this->mover($broker_origen, $broker_destino, Ticker::byName($activo)->activo);
        }
    }
}