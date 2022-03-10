<?php

namespace App\Models\Movimientos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Cuenta;
use App\Models\Activos\Activo;

class Movimiento extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::MOVIMIENTOS;

    protected $guarded = [];

    protected $dates = [
        'fecha_operacion',
        'fecha_liquidacion'
    ];

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function Cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function Broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function getClaseAttribute()
    {
    	$classname = get_class($this);

        if ($pos = strrpos($classname, '\\')) 
        {
            return substr($classname, $pos + 1);
        }

        return $pos;
    }

    public function getMontoAttribute()
    {
    	return $this->monto_en_moneda_original;
    }

    public function getSaldoAttribute()
    {
    	return $this->saldo_calculado_en_moneda_original;
    }

    public function getRemanenteAttribute()
    {
    	return abs($this->cantidad) - $this->cantidad_imputada;
    }

    public function scopeDeFondos($query)
    {
        return $query->where('tipo_operacion', 'Deposito')->orWhere('tipo_operacion', 'Extraccion');
    }

    public function scopeResumir($query)
    {
        return $query->selectRaw('broker_id, sum(IF(`tipo_operacion` = "Deposito", `monto_en_pesos`, 0)) as suma_de_depositos_en_pesos, sum(IF(`tipo_operacion` = "Extraccion", `monto_en_pesos`, 0)) as suma_de_extracciones_en_pesos, sum(IF(`tipo_operacion` = "Deposito", `monto_en_dolares`, 0)) as suma_de_depositos_en_dolares, sum(IF(`tipo_operacion` = "Extraccion", `monto_en_dolares`, 0)) as suma_de_extracciones_en_dolares')
            ->groupBy(['broker_id']);
    }
}