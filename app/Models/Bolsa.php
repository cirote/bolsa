<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Bolsa extends Model
{
    protected $table = Config::PREFIJO . Config::BOLSAS;

    static public function bySigla($sigla)
    {
        return static::where('sigla', $sigla)->first();
    }
}
