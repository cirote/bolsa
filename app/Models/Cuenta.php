<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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

    public function scopeConSaldos($query, Carbon $fecha = null)
    {
        if (! $fecha)
        {
            $fecha = Carbon::now();
        }

        return $query->addSelect(['saldo' => Movimiento::select('saldo_calculado_en_moneda_original')
            ->whereColumn('cuenta_id', Config::PREFIJO . Config::CUENTAS . '.id')
            ->where('fecha_operacion', '<=', $fecha)
            ->orderBy('fecha_operacion', 'DESC')
            ->orderBy('id', 'DESC')
            ->take(1)
        ]);
    }
}
