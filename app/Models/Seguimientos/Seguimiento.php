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

    public function getTechoCalculadoAttribute($value)
    {
        return $this->base + $this->amplitud;
    }

    public function getBaseAttribute()
    {
        if (! $this->fecha_1)
        {
            return $this->base_1;
        }

        if ($this->tipo == 'LogChannel')
        {
            return $this->base_logaritmica();    
        }

        elseif ($this->tipo == 'Channel')
        {
            return $this->base_lineal();    
        }

        return 0;
    }

    protected function base_logaritmica()
    {
        if (!($this->fecha_1 instanceof Carbon && $this->fecha_2 instanceof Carbon)) 
        {
            throw new \Exception('Las fechas deben ser instancias de Carbon');
        }

        $diasTotales = $this->fecha_1->diffInDays($this->fecha_2);

        $diasHastaHoy = $this->fecha_1->diffInDays(Carbon::now());

        $diferenciaLogaritmica = log($this->base_2) - log($this->base_1);

        $pendiente = $diferenciaLogaritmica / $diasTotales;

        $constante = log($this->base_1);

        $valorFinalLogaritmico = $pendiente * $diasHastaHoy + $constante;

        return exp($valorFinalLogaritmico);
    }

    protected function base_lineal()
    {
        if (!($this->fecha_1 instanceof Carbon && $this->fecha_2 instanceof Carbon)) 
        {
            throw new \Exception('Las fechas deben ser instancias de Carbon');
        }

        $diasTotales = $this->fecha_1->diffInDays($this->fecha_2);

        $diasHastaHoy = $this->fecha_1->diffInDays(Carbon::now());

        $diferencia = $this->base_2 - $this->base_1;

        $pendiente = $diferencia / $diasTotales;

        $constante = $this->base_1;

        return $pendiente * $diasHastaHoy + $constante;
    }

    public function getPuntajeAttribute()
    {
        if (!is_numeric($this->activo->cotizacion))
        {
            return 0;
        }

        return $this->amplitud
            ? ($this->activo->cotizacion - $this->base) / $this->amplitud
            : 0;
    }

    public function getAccionAttribute()
    {
        if (! $this->tipo)
        {
            return '';
        }

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
        
        return '';
        return 'Mantener';
    }

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }
}