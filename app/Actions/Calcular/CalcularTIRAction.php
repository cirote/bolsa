<?php

namespace App\Actions\Calcular;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CalcularTIRAction
{
    static function do()
    {
        static::xirr([
            ['cantidad' => -1000, 'fecha' => Carbon::create(2016, 0, 15)],
            ['cantidad' => -2500, 'fecha' => Carbon::create(2016, 1, 8)],
            ['cantidad' => -1000, 'fecha' => Carbon::create(2016, 3, 17)],
            ['cantidad' => 5050, 'fecha' => Carbon::create(2016, 7, 24)],
        ]);

        // 0.2504234710540838
    }

    static function xirr(Array $datos)
    {
        $base = array_shift($datos)['fecha'];

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

        $step = 0.05;

        $guess = 0.05;
        
        $epsilon = 0.0001;
        
        $limit = 100;

        while((abs($residual) > $epsilon) && ($limit > 0))
        {
            $limit--;

            $residual = 0;

            foreach($transactions as $transaction)
            {
                $residual += $transaction['cantidad'] / pow($guess, $transaction['año']);
            }

            if (abs($residual) > $epsilon)
            {
                if ($residual > 0)
                {
                    $guess += $step;
                }

                else 
                {
                    $guess -= $step;

                    $step = $step / 2;
                }
            }
        }

        $tir = ($guess - 1) * 100;

        dd($tir);
    }
}