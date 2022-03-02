<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Cheque extends Posicion
{
    use HasParent;
}