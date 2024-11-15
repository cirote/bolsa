<?php

namespace App\Models\Seguimientos;

use Illuminate\Support\Carbon;

class LogChannel extends Base
{
    public function techoCalculado()
    {
        return $this->seguimiento->base * (1 + ($this->seguimiento->amplitud / 100));
    }

    public function base()
    {
        if (! $this->seguimiento->fecha_1)
        {
            return $this->seguimiento->base_1;
        }

        if ($this->seguimiento->tipo == 'LogChannel')
        {
            return $this->base_logaritmica();    
        }

        elseif ($this->seguimiento->tipo == 'Channel')
        {
            return $this->base_lineal();    
        }

        return 0;
    }

    private function base_logaritmica()
    {
        if (!($this->seguimiento->fecha_1 instanceof Carbon && $this->seguimiento->fecha_2 instanceof Carbon)) 
        {
            throw new \Exception('Las fechas deben ser instancias de Carbon');
        }

        $diasTotales = $this->seguimiento->fecha_1->diffInDays($this->seguimiento->fecha_2);

        $diasHastaHoy = $this->seguimiento->fecha_1->diffInDays(Carbon::now());

        $diferenciaLogaritmica = log($this->seguimiento->base_2) - log($this->seguimiento->base_1);

        $pendiente = $diferenciaLogaritmica / $diasTotales;

        $constante = log($this->seguimiento->base_1);

        $valorFinalLogaritmico = $pendiente * $diasHastaHoy + $constante;

        return exp($valorFinalLogaritmico);
    }

    private function base_lineal()
    {
        if (!($this->seguimiento->fecha_1 instanceof Carbon && $this->seguimiento->fecha_2 instanceof Carbon)) 
        {
            throw new \Exception('Las fechas deben ser instancias de Carbon');
        }

        $diasTotales = $this->seguimiento->fecha_1->diffInDays($this->seguimiento->fecha_2);

        $diasHastaHoy = $this->seguimiento->fecha_1->diffInDays(Carbon::now());

        $diferencia = $this->seguimiento->base_2 - $this->seguimiento->base_1;

        $pendiente = $diferencia / $diasTotales;

        $constante = $this->seguimiento->base_1;

        return $pendiente * $diasHastaHoy + $constante;
    }

    public function puntaje()
    {
        if (! is_numeric($this->seguimiento->activo->cotizacion))
        {
            return 0;
        }

        return $this->seguimiento->amplitud
            ? ($this->seguimiento->activo->cotizacion - $this->seguimiento->base) / $this->seguimiento->amplitud
            : 0;
    }

    public function estado()
    {
        if (! $this->seguimiento->tipo)
        {
            return '';
        }

        if ($this->seguimiento->puntaje >= 1)
        {
            return 'Vender';
        }

        if ($this->seguimiento->puntaje >= 0.9)
        {
            return 'Lanzar CALL';
        }

        if ($this->seguimiento->puntaje <= 0)
        {
            return 'Comprar';
        }

        if ($this->seguimiento->puntaje <= 0.1)
        {
            return 'Lanzar PUT';
        }
        
        return '';
        return 'Mantener';
    }
}