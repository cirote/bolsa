<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Movimiento extends Model
{
    protected $table = Config::PREFIJO . Config::MOVIMIENTOS;

    protected $guarded = [];
}