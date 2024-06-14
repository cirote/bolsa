<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Activos\Activo;

class Seguimiento extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::SEGUIMIENTOS;

    protected $guarded = [];

    protected $dates = [
        'fecha_1',
        'fecha_2'
    ];

    public function getAmplitudAttribute($value)
    {
        return $value / $this->base_1 * $this->base;
    }

    public function getBaseAttribute()
    {
        if (! $this->fecha_1)
        {
            return $this->base_1;
        }

        $dias = $this->fecha_1->diff($this->fecha_2)->days / 7 * 5;

        $dias_hasta_hoy = $this->fecha_1->diff(Carbon::now())->days / 7 * 5;

        $diferencia = $this->base_2 - $this->base_1;

        return $this->base_1 + ($diferencia / $dias) * $dias_hasta_hoy;
    }

    public function getPuntajeAttribute()
    {
        if (!is_numeric($this->activo->cotizacion))
        {
            return 0;
        }

        return ($this->activo->cotizacion - $this->base) / $this->amplitud;
    }

    public function getAccionAttribute()
    {
        if ($this->puntaje >= 1)
        {
            return 'Vender';
        }

        if ($this->puntaje >= 0.9)
        {
            return 'Lanzar CALL';
        }

        if ($this->puntaje <= 0)
        {
            return 'Comprar';
        }

        if ($this->puntaje <= 0.1)
        {
            return 'Lanzar PUT';
        }
        
        return 'Mantener';
    }

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }
}