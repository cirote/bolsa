<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Compraventa extends Model
{
    protected $table = Config::PREFIJO . Config::COMPRAVENTAS;

    protected $guarded = [];

    public function compra()
    {
        return $this->belongsTo(Operacion::class, 'operacion_compra_id');
    }

    public function venta()
    {
        return $this->belongsTo(Operacion::class, 'operacion_venta_id');
    }

    public function getCostoAttribute()
    {
        return $this->compra->precio * $this->cantidad;
    }

    public function getIngresoAttribute()
    {
        return $this->venta->precio * $this->cantidad;
    }

    public function getResultadoAttribute()
    {
        return $this->ingreso - $this->costo;
    }

    public function getDiasAttribute()
    {
        return $this->venta->fecha->diffInDays($this->compra->fecha);
    }

    public function getTasaAttribute()
    {
        if (! $this->costo)
            return 0;

        if ($this->dias == 0)
            return 0;

        return $this->resultado / $this->costo / $this->dias * 365;
    }
}