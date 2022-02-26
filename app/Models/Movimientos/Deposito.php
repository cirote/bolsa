<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Deposito extends Movimiento
{
    use HasParent;
}