<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Comision extends Posicion
{
    use HasParent;
}