<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Historico extends Model
{
    protected $table = Config::PREFIJO . Config::HISTORICOS;

    protected $guarded = [];
}
