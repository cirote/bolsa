<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Ejercicio extends Movimiento
{
    use HasParent;
}