<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Config\Constantes as Config;
use App\Models\Movimientos\Movimiento;
use App\Models\Activos\Moneda;

class Cuenta extends Model
{
    protected $table = Config::PREFIJO . Config::CUENTAS;

    protected $guarded = [];
    
    static public function bySigla($sigla)
    {
        return static::where('sigla', $sigla)->first();
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    // public function calcular_saldos()
    // {
    //     $saldo = 0;

    //     foreach($this->movimientos as $movimiento)
    //     {
    //         $saldo += $movimiento->monto_en_moneda_original;

    //         $movimiento->saldo_calculado_en_moneda_original = $saldo;

    //         $movimiento->save();
    //     }
    // }

    public function scopeConSaldos($query, Carbon $fecha = null)
    {
        return $query->addSelect([
            'saldo' => Movimiento::select('saldo_calculado_en_moneda_original')
                        ->whereColumn('cuenta_id', Config::PREFIJO . Config::CUENTAS . '.id')
                        ->where('fecha_operacion', '<=', $fecha ?? Carbon::now())
                        ->orderBy('fecha_operacion', 'DESC')
                        ->orderBy('id', 'DESC')
                        ->take(1)
        ]);
    }
}
