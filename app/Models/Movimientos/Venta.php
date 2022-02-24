<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Venta extends Movimiento
{
    use HasParent;
}