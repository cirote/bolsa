<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CalcularTIRAction
{
    static function do()
    {
        return static::xirr([
            ['cantidad' => 1000, 'fecha' => Carbon::create(2016, 1, 15)],
            ['cantidad' => 2500, 'fecha' => Carbon::create(2016, 2, 8)],
            ['cantidad' => 1000, 'fecha' => Carbon::create(2016, 4, 17)],
            ['cantidad' => -5050, 'fecha' => Carbon::create(2016, 8, 24)],
        ]);

        // 0.2504234710540838
    }

    static function xirr(Array $datos)
    {
        $dato_base = array_shift($datos);

        $base = $dato_base['fecha'];

        $monto = $dato_base['cantidad'];

        if ($monto < 0) 
        {
            throw new Exception('El valor inicial no puede ser negativo.');
        }

        if ($monto == 0) 
        {
            throw new Exception('El valor inicial no puede ser cero.');
        }

        $transactions = [];

        foreach($datos as $dato)
        {
            $transactions[] = [
                'fecha'    => $dato['fecha'],
                'cantidad' => $dato['cantidad'],
                'año'      => $base->diffInDays($dato['fecha']) / 365
            ];
        }

        $residual = 1.0;

        $step = 0.10;

        $guess = 0.6;
        
        $epsilon = 0.0001;
        
        $limit = 1000;

        while((abs($residual) > $epsilon) && ($limit > 0))
        {
            $limit--;

            $residual = $monto;

            foreach($transactions as $transaction)
            {
                $residual += $transaction['cantidad'] / pow((1 + $guess), $transaction['año']);
            }

            if (abs($residual) > $epsilon)
            {
                if ($residual > 0)
                {
                    $guess -= $step;
                }

                else 
                {
                    $guess += 0.5 * $step;

                    $step = $step / 2;
                }
            }
        }

        return $guess;
    }
}