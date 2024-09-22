<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Config\Constantes as Config;
use App\Models\Activos\Activo;

class Banda extends Model
{
    protected $table = Config::PREFIJO . Config::BANDAS;

    protected $guarded = [];

    protected $dates = ['fecha_operacion'];

    protected function grilla()
    {
        return $this->belongsTo(Grilla::class);
    }

    public function getPrecioEnEntornoAttribute()
    {
        $precio = $this->grilla->cotizacionDelActivo;

        if ($precio > $this->limite_inferior)
        {
            if ($this->limite_superior)
            {
                if ($precio < $this->limite_superior)
                {
                    return true;    
                }
            }

            else
            {
                return true;    
            }
        }

        return false;
    }

    public function scopeActiva(Builder $query): void
    {
        $query->where('estado', 1);
    }
    
    public function scopeConLimites(Builder $query): void
    {
        $query->addSelect([
            'limite_superior' => Banda::select('precio')
                ->from('ac_bandas as bandas')
                ->whereColumn('bandas.grilla_id', 'ac_bandas.grilla_id')
                ->whereColumn('bandas.precio', '>', 'ac_bandas.precio')
                ->orderBy('bandas.precio')
                ->limit(1)
        ]);

        $query->addSelect([
            'limite_inferior' => Banda::select('precio')
                ->from('ac_bandas as bandas')
                ->whereColumn('bandas.grilla_id', 'ac_bandas.grilla_id')
                ->whereColumn('bandas.precio', '<', 'ac_bandas.precio')
                ->orderBy('bandas.precio', 'DESC')
                ->limit(1)
        ]);
    }
}