<?php

namespace App\Traits;

use App\Models\Activos\Activo;

trait Trading
{
    public function trading(Activo $activo)
    {
        return redirect()->route('trading.activo', ['activo' => $activo]);
    }
}