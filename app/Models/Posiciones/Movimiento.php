<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Movimiento extends Model
{
    protected $table = Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES;

    protected $guarded = [];

    public function operacion()
    {
        return $this->belongsTo(\App\Models\Movimientos\Movimiento::class, 'movimiento_id', 'id');
    }
}