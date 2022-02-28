<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Extraccion extends Movimiento
{
    use HasParent;
}