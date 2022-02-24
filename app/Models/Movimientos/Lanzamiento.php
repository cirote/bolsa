<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Lanzamiento extends Movimiento
{
    use HasParent;
}