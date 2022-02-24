<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Recepcion extends Movimiento
{
    use HasParent;
}