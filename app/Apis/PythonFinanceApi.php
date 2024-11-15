<?php

namespace App\Apis;

use Carbon\Carbon;

class PythonFinanceApi
{
    private static $objeto = null;

    static function get()
    {
        if (! static::$objeto)
        {
            static::$objeto = new static();
        }

        return static::$objeto;
    }

    static function obtenerDatosCotizacion($ticker, Carbon $fecha) 
    {
        $fecha_formateada = $fecha->format('Y-m-d');
    
        $url = "http://127.0.0.1:8080/minimo_historico?ticker=$ticker&fecha=$fecha_formateada";
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_HTTPGET, true);         
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        }
    
        curl_close($ch);
    
        $datos_cotizacion = json_decode($response, true);

        return $datos_cotizacion;
    }
}