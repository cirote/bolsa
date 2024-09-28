<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;
use App\Models\Activos\Activo;

class Grilla extends Model
{
    protected $table = Config::PREFIJO . Config::GRILLA;

    protected $guarded = [];

    protected $casts = [
        'fecha_inicial' => 'datetime:Y-m-d'
    ];    

    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function bandas()
    {
        return $this->hasMany(Banda::class);
    }

    public function bandaActiva()
    {
        return $this->bandas()->activa()->conLimites();
    }

    protected $_cotizacionDelActivo = null;

    public function getCotizacionDelActivoAttribute()
    {
        if ($this->_cotizacionDelActivo == null)
        {
            $this->_cotizacionDelActivo = $this->activo->cotizacion;
        }

        return $this->_cotizacionDelActivo;
    }

    public function getEstadoAttribute()
    {
        if($this->precio_activacion !== null)
        {
            return $this->precio_activacion >= $this->cotizacionDelActivo ? 'Corresponde activar' : '' ;
        }

        else
        {
            return $this->hayCambioDeBanda ? 'Cambio de banda' : '';
        }

        return '';
    }

    protected $_idBandaActual = 0;

    protected $_hayCambioDeBanda = null;

    public function getIdBandaActualAttribute()
    {
        if (! $this->_idBandaActual)
        {
            if (! $this->bandas()->count())
            {
                $this->_idBandaActual = 0;

                $this->_hayCambioDeBanda = false;
            }

            else
            {
                $bandaActiva = $this->bandaActiva()->first();

                if ($bandaActiva->precioEnEntorno ?? false)
                {
                    $this->_idBandaActual = $bandaActiva->id;

                    $this->_hayCambioDeBanda = false;
                }

                else
                {
                    $bandas = $this->bandas()->conLimites()->orderBy('precio')->get();

                    $filtradas = $bandas->filter(function ($banda) 
                    {
                        return $banda->precioEnEntorno;
                    });

                    if ($filtradas->count() == 0)
                    {
                        $bandas = $this->bandas()->conLimites()->first();

                        $this->_idBandaActual = $bandas->id;
                    }

                    elseif ($filtradas->count() == 1)
                    {
                        $this->_idBandaActual = $filtradas->first()->id;
                    }

                    else
                    {
                        if (! $bandaActiva)
                        {
                            $this->_idBandaActual = 0;
                        }

                        elseif ($filtradas->first()->precio > $bandaActiva->precio)
                        {
                            $this->_idBandaActual = $filtradas->first()->id;
                        }

                        else
                        {
                            $this->_idBandaActual = $filtradas->last()->id;
                        }
                    }

                    $this->_hayCambioDeBanda = true;
                }
            }
        }

        return $this->_idBandaActual;
    }

    public function getHayCambioDeBandaAttribute()
    {
        if ($this->_hayCambioDeBanda == null)
        {
            $this->getIdBandaActualAttribute();
        }

        return $this->_hayCambioDeBanda;
    }
}