<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Dividendo extends Movimiento
{
    use HasParent;
}