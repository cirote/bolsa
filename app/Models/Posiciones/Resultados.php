<?php

namespace App\Models\Posiciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Posiciones\Movimiento;

trait Resultados
{
    abstract public function getCantidadAttribute();

    abstract public function getInversionAttribute();

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

        return $this->getCantidadAttribute() * $this->getPrecioAttribute();
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

    public function getUtilidadAttribute()
    {
        if ($inversion = abs($this->getInversionAttribute()))
        {
            return $this->getResultadoAttribute() / $inversion;
        }

        return 0;
    }
}