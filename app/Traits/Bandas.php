<?php

namespace App\Traits;

use App\Models\Seguimientos\Grilla;

trait Bandas
{
    public function ver_bandas(Grilla $grilla)
    {
        return redirect()->route('grillas.bandas', 
            [
                'header' => 'Bandas de precios',
                'grilla' => $grilla
            ]
        );
    }
}