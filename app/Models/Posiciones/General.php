<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Posiciones\Movimiento;

class General extends Model
{
    public $timestamps = false;

    protected $table = Config::PREFIJO . Config::POSICIONES;

    public function save(array $options = [])
    {
        return false;
    }

    public function update(array $attributes = [], array $options = [])
    {
        return false;
    }
  
    public function delete()
    {
        return false;
    }
  
    public static function destroy($ids)
    {
        return 0;
    }

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function Posiciones()
    {
        return $this->hasMany(Posicion::class, 'activo_id', 'activo_id')
            ->where('estado', 'Abierta');
    }

    protected static function booted()
    {
        static::addGlobalScope('base', function (Builder $builder) 
        {
            $builder->select('activo_id')
                ->where('estado', 'Abierta')
                ->distinct();
        });
    }

    public function getClaseAttribute()
    {
    	$classname = get_class($this->posiciones()->first());

        if ($pos = strrpos($classname, '\\')) 
        {
            return Str::title(Str::snake(substr($classname, $pos + 1), ' '));
        }

        return Str::title(Str::snake($pos, ' '));
    }

    protected $cantidad;

    public function getCantidadAttribute()
    {
        if (!$this->cantidad)
        {
            $this->cantidad = $this->posiciones()->sum('cantidad');
        }

        return $this->cantidad;
    }

    protected $inversion;

    public function getInversionAttribute()
    {
        if (!$this->inversion)
        {
            $this->inversion = $this->posiciones()->conResultados()->get()->sum('movimientos_sum_monto_parcial_en_dolares');
        }

        return $this->inversion;
    }

    public function getUnitarioAttribute()
    {
        if (!$this->getCantidadAttribute())
        {
            return null;
        }

        return abs($this->getInversionAttribute() / $this->getCantidadAttribute());
    }

    protected $precio;

    public function getPrecioAttribute()
    {
        if (!$this->precio)
        {
            $p = $this->activo->cotizacion;

            $this->precio = is_numeric($p) ? $p : 0;
        }

        return $this->precio;
    }

    public function getValorAttribute()
    {
        if (!$this->getCantidadAttribute())
        {
            return null;
        }

        return $this->getCantidadAttribute() * $this->precio;
    }

    public function getResultadoAttribute()
    {
        if (!$this->getCantidadAttribute())
        {
            return null;
        }

        if ($this->clase == 'Larga')
        {
            return $this->getValorAttribute() + $this->getInversionAttribute();
        }

        return $this->getInversionAttribute() - $this->getValorAttribute();
    }

    public function scopeConCantidad($query)
    {
        return $query->withSum('posiciones', 'cantidad');
    }
}