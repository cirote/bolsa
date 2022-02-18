<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Broker extends Model
{
    protected $table = Config::PREFIJO . Config::BROKERS;

    static public function byName($name)
    {
        return static::where('nombre', $name)->first();
    }

    static public function bySigla($sigla)
    {
        return static::where('sigla', $sigla)->first();
    }
}
