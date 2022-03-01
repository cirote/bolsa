<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;
use App\Models\Movimientos\Movimiento as Operacion;

class Movimiento extends Model
{
    protected $table = Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES;

    protected $guarded = [];

    public function movimiento()
    {
        return $this->belongsTo(Operacion::class);
    }
}