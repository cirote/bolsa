<?php

namespace App\Models\Contables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Activos\Accion;
use App\Models\Activos\Call;
use App\Models\Posiciones\Posicion;
use App\Models\Posiciones\Comision;
use App\Models\Posiciones\Corta;
use App\Models\Posiciones\Dividendo;
use App\Models\Posiciones\Larga;
use App\Models\Posiciones\LanzamientoCubierto;

class Resultado extends Model
{
    protected $table = Config::PREFIJO . Config::RESULTADOS;

    protected $guarded = [];

    protected $dates = [
        'fecha_inicial',
        'fecha_final'
    ];

    public function posiciones()
    {
        return Posicion::cerradas()
            ->conResultados()
            ->where('fecha_cierre', '>', $this->fecha_inicial)
            ->where('fecha_cierre', '<=', $this->fecha_final);
    }

    public function getPosicionesAttribute()
    {
        return $this->posiciones()->get();
    }

    public function posiciones_capital()
    {
        return $this->posiciones()
            ->where(function($query) 
            {
                $query->where('type', Larga::class)
                ->orWhere('type', Corta::class);
            });
    }

    public function getPosicionesCapitalAttribute()
    {
        return $this->posiciones_capital()->get();
    }

    private $capital = 0;

    public function getCapitalAttribute()
    {
        if (! $this->capital)
        {
            foreach($this->posicionesCapital as $posicion)
            {
                if (! ($posicion->activo instanceof Call))
                {
                    $this->capital += $posicion->resultado;
                }
            }
        }

        return $this->capital;
    }

    private $opciones = 0;

    public function getOpcionesAttribute()
    {
        if (! $this->opciones)
        {
            foreach($this->posicionesCapital as $posicion)
            {
                if ($posicion->activo instanceof Call)
                {
                    $this->opciones += $posicion->resultado;
                }
            }
        }

        return $this->opciones;
    }

    public function posiciones_lanzamientos()
    {
        return $this->posiciones()
            ->where(function($query) 
            {
                $query->where('type', LanzamientoCubierto::class);
            });
    }

    public function getPosicionesLanzamientosAttribute()
    {
        return $this->posiciones_lanzamientos()->get();
    }

    private $lanzamientos = 0;

    public function getLanzamientosAttribute()
    {
        if (! $this->lanzamientos)
        {
            foreach($this->posicionesLanzamientos as $posicion)
            {
                $this->lanzamientos += $posicion->resultado;
            }
        }

        return $this->lanzamientos;
    }

    public function posiciones_dividendos()
    {
        return $this->posiciones()
            ->where('type', Dividendo::class);
    }

    public function getPosicionesDividendosAttribute()
    {
        return $this->posiciones_dividendos()->get();
    }

    private $dividendo = 0;

    public function getDividendosAttribute()
    {
        if (! $this->dividendo)
        {
            foreach($this->posicionesDividendos as $posicion)
            {
                if ($posicion->activo instanceof Accion)
                {
                    $this->dividendo += $posicion->resultado;
                }
            }
        }

        return $this->dividendo;
    }

    private $renta = 0;

    public function getRentasAttribute()
    {
        if (! $this->renta)
        {
            foreach($this->posicionesDividendos as $posicion)
            {
                if (! ($posicion->activo instanceof Accion))
                {
                    $this->renta += $posicion->resultado;
                }
            }
        }

        return $this->renta;
    }
    
    public function posiciones_comisiones()
    {
        return $this->posiciones()
            ->where('type', Comision::class);
    }

    public function getPosicionesComisionesAttribute()
    {
        return $this->posiciones_comisiones()->get();
    }

    private $comision = 0;

    public function getComisionesAttribute()
    {
        if (! $this->comision)
        {
            foreach($this->posicionesComisiones as $posicion)
            {
                $this->comision += $posicion->resultado;
            }
        }

        return $this->comision;
    }

    public function getResultadoAttribute()
    {
        return $this->getCapitalAttribute() + $this->getLanzamientosAttribute() 
            + $this->getOpcionesAttribute() + $this->getDividendosAttribute() 
            + $this->getRentasAttribute() + $this->getComisionesAttribute();
    }

    public function getResultadoTeoricoAttribute()
    {
        return $this->getVariacionInversionAttribute() + $this->getVariacionSaldoEnDolaresAttribute()
            + $this->getVariacionAportesAttribute();
    }
    
    public function getResultadoAConsolidarAttribute()
    {
        return $this->getResultadoAttribute() - $this->getResultadoTeoricoAttribute();
    }

    public function estado_inicial()
    {
        return $this->hasOne(Estado::class, 'fecha', 'fecha_inicial');
    }

    public function estado_final()
    {
        return $this->hasOne(Estado::class, 'fecha', 'fecha_final');
    }

    public function getVariacionInversionAttribute()
    {
        return $this->estado_final->inversion - $this->estado_inicial->inversion;
    }

    public function getVariacionSaldoEnDolaresAttribute()
    {
        return $this->estado_final->cuentasSaldoEnDolares - $this->estado_inicial->cuentasSaldoEnDolares;
    }

    public function getVariacionAportesAttribute()
    {
        return $this->estado_final->aportesNetos - $this->estado_inicial->aportesNetos;
    }
}