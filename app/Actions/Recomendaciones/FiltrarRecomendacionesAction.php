<?php

namespace App\Actions\Recomendaciones;

use App\Models\Activos\Activo;
use App\Models\Seguimientos\Notificacion;
use App\Models\Seguimientos\Grilla;
use App\Models\Seguimientos\Seguimiento;

class FiltrarRecomendacionesAction
{
    protected $estados = [];

    protected $datosNuevos = [];

    protected $datosSobrantes = [];

    static public function do()
    {
        return (new static())->execute();
    }

    protected function execute()
    {
        $this->obtener_datos();

        $this->sincronizar_datos();

        $texto = $this->notificar();

        dd($texto);

        return $this->estados;
    }

    public function obtener_datos()
    {
        $this->normalice('Activos', Activo::conStock()->filter(function ($activo) 
        {
            return $activo->estado != '';
        }));
    
        $this->normalice('Seguimientos', Seguimiento::with('activo')->get()->filter(function ($activo) 
        {
            return $activo->estado != '';
        }));
    
        $this->normalice('Grillas', Grilla::all()->filter(function ($activo) 
        {
            return $activo->estado != '';
        }));
    }

    protected function normalice($origen, $datos)
    {
        foreach($datos as $dato)
        {
            $this->estados[] = [
                'origen' => $origen,
                'ticker' => $dato->simbolo ?? $dato->activo->simbolo,
                'accion' => $dato->estado ?? $dato->activo->estado
            ];
        }
    }

    protected function sincronizar_datos()
    {
        $notificaciones = Notificacion::select('id', 'origen', 'ticker', 'accion')
            ->where('estado', true)
            ->get();

        $datosTablaArray = $notificaciones->toArray();

        $this->datosNuevos = array_udiff($this->estados, $datosTablaArray, function($a, $b) {
            return strcmp(
                json_encode(['origen' => $a['origen'], 'ticker' => $a['ticker'], 'accion' => $a['accion']]), 
                json_encode(['origen' => $b['origen'], 'ticker' => $b['ticker'], 'accion' => $b['accion']])
            );
        });

        foreach ($this->datosNuevos as $dato) {
            Notificacion::create($dato);
        }

        $this->datosSobrantes = array_udiff($datosTablaArray, $this->estados, function($a, $b) {
            return strcmp(
                json_encode(['origen' => $a['origen'], 'ticker' => $a['ticker'], 'accion' => $a['accion']]), 
                json_encode(['origen' => $b['origen'], 'ticker' => $b['ticker'], 'accion' => $b['accion']])
            );
        });

        $idsSobrantes = array_column($this->datosSobrantes, 'id');

        Notificacion::whereIn('id', $idsSobrantes)->update(['estado' => false]);
    }

    protected function notificar()
    {
        $texto = '';

        if ($t = $this->notificar_nuevos()) 
        {
            $texto .= 'Hay nuevas recomendaciones: ' . PHP_EOL;

            $texto .= $t;
        }

        if ($t = $this->notificar_sobrantes()) 
        {
            $texto .= 'Hay recomendaciones que desaparecen: ' . PHP_EOL;

            $texto .= $t;
        }

        return $texto;
    }

    protected function notificar_nuevos()
    {
        $texto = '';

        foreach ($this->datosNuevos as $dato) {
            $texto .= " - Nuevo {$dato['origen']} {$dato['ticker']} con estado {$dato['accion']}\n";
        }

        return $texto;
    }

    protected function notificar_sobrantes()
    {
        $texto = '';

        foreach ($this->datosSobrantes as $dato) {
            $notificacion = Notificacion::find($dato['id']);

            $texto .= " - Sobrante {$dato['origen']} {$dato['ticker']} con estado {$dato['accion']} desde {$notificacion->created_at->format('d/m/Y')}\n";
        }

        return $texto;
    }
}