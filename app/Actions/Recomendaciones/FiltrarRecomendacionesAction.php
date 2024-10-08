<?php

namespace App\Actions\Recomendaciones;

use App\Models\Activos\Activo;
use App\Models\Operaciones\Operacion;
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

        if ($texto) 
        {
            $this->enviar_mensaje($texto);
        }
    }

    protected function enviar_mensaje($texto)
    {
        // $token = '';
        $token = 'EAAxZBKSG6socBO0bOVM4ORbzmsDiyjXdvXtJI0XdCuhhSZAjJzyVXFL3RNuoUv3BjUBJUuAQOcPVtPwSW51D2l4S9lKXRXGlgBnSuK7mM7qWc0kZCi16NHQcHZAu2B6tCw1Im3hvI24a16A0W1Fm4j4hfYLF1Ad9ZCmPj7QLvZCZBgTBKZBNItKZC6QgBZB5f0p4TuYNzpIjT4IovBlCYCMurmGt9D';
        $phone_number_id = '443328075527104';
        $recipient_phone_number = '59897103023';

        $tsap = new \zepson\Whatsapp\WhatsappClass($phone_number_id, $token, "v20.0");

        try 
        {
            $sendtsap = $tsap->sendMessage(
                $texto,
                $recipient_phone_number
            );

            // dump($sendtsap);
        } 
        
        catch (\Exception $e) 
        {
            dump('Error al enviar el mensaje: ' . $e->getMessage());
        }
    }

    public function obtener_datos()
    {
        $activos_con_movimientos = Operacion::query()
            ->pluck('activo_id')
            ->unique();

        $this->normalice('Activos', Activo::whereIn('id', $activos_con_movimientos)->get()->filter(function ($activo) 
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
                'ticker' => $dato->simbolo ?? ($dato->ticker->ticker ?? 'n/d'),
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
            $texto .= 'Hay recomendaciones que se vencieron: ' . PHP_EOL;

            $texto .= $t;
        }

        return $texto;
    }

    protected function notificar_nuevos()
    {
        $texto = '';

        foreach ($this->datosNuevos as $dato) {
            $texto .= " - Nuevo {$dato['origen']} {$dato['ticker']} con estado {$dato['accion']}" . PHP_EOL;
        }

        return $texto;
    }

    protected function notificar_sobrantes()
    {
        $texto = '';

        foreach ($this->datosSobrantes as $dato) {
            $notificacion = Notificacion::find($dato['id']);

            $texto .= " - Oportunidad en {$dato['origen']} para {$dato['ticker']} con recomendacion de {$dato['accion']} desde el {$notificacion->created_at->format('d/m/Y')}" . PHP_EOL;
        }

        return $texto;
    }
}