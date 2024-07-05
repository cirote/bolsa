<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Impuesto extends Movimiento
{
    use HasParent;
}