<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Venta extends Operacion
{
    use HasParent;
}
