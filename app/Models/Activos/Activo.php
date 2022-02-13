<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use App\Config\Constantes as Config;

class Activo extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::ACTIVOS;

    protected $guarded = [];
}