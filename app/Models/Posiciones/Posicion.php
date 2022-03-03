<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Posiciones\Movimiento;

class Posicion extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::POSICIONES;

    protected $guarded = [];

    protected $dates = [
        'fecha_apertura',
        'fecha_cierre'
    ];

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function Broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function Movimientos()
    {
        return $this->hasMany(Movimiento::class);
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

    public function scopeAbiertas($query)
    {
        return $query->where('estado', 'Abierta');
    }

    public function scopeCerradas($query)
    {
        return $query->where('estado', 'Cerrada');
    }

    public function scopeCortas($query)
    {
        return $query->where('tipo', 'Corta');
    }

    public function scopeLargas($query)
    {
        return $query->where('tipo', 'Larga');
    }

    public function scopeByActivo($query, Activo $activo)
    {
        return $query->where('activo_id', $activo->id);
    }

    public function scopeByBroker($query, Broker $broker)
    {
        return $query->where('broker_id', $broker->id);
    }

    public function scopeByApertura($query)
    {
        return $query->orderBy('fecha_apertura');
    }

    public function scopeByCierre($query)
    {
        return $query->orderByDesc('fecha_cierre');
    }

    public function scopeConResultados($query)
    {
        return $query->withSum('movimientos', 'monto_parcial_en_moneda_original');
        
        return $query->addSelect(['resultado_en_moneda_original' => Movimiento::whereColumn('posicion_id', Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES . '.id')
            ->sum('monto_parcial_en_moneda_original')
        ]);
    }

    public function getResultadoAttribute()
    {
        return $this->movimientos_sum_monto_parcial_en_moneda_original;
    }

    public function scopeResumir($query)
    {
        return $query->selectRaw('activo_id, sum(cantidad) as cantidad, sum(cantidad * precio_en_dolares) as precioXcantidad, max(tipo) as tipo, max(precio_en_dolares) as mayor_precio_en_dolares, min(precio_en_dolares) as menor_precio_en_dolares, sum(monto_en_dolares) as monto_total_en_dolares, sum(resultado_en_dolares) as resultado_en_dolares')
            ->groupBy('activo_id');
    }
}