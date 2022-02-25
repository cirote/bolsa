<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;
use App\Models\Movimientos\Movimiento;

class Cuenta extends Model
{
    protected $table = Config::PREFIJO . Config::CUENTAS;

    protected $guarded = [];
    
    static public function bySigla($sigla)
    {
        return static::where('sigla', $sigla)->first();
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}