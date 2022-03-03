<?php

namespace App\Actions;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Movimientos\Ejercicio;
use App\Models\Movimientos\Movimiento;
use App\Models\Movimientos\Venta;
use App\Models\Posiciones\Corta;
use App\Models\Posiciones\Larga;
use App\Models\Posiciones\Posicion;

class ImputarMovimientosOriginalesEnPosicionesAction
{
    static public function do()
    {
        return (new static())->execute();
    }

    public function execute()
    {
        $this->detectarEjerciciosCall();

        foreach (Movimiento::with('activo', 'broker')->where('pendiente', true)->orderBy('fecha_operacion')->get() as $movimiento) 
        {
            dump($movimiento->clase);

            if (in_array($movimiento->clase, ['Compra', 'Recepcion'])) 
            {
            //     while ($movimiento->remanente) 
            //     {
            //         if ($posicion_a_cerrar = $this->posicionesCortas($movimiento->activo, $movimiento->broker)->first()) 
            //         {
            //             $this->cerrarPosicion($posicion_a_cerrar, $movimiento);
            //         } 
                    
            //         else 
                    {
                        $this->crearPosicion(Larga::class, $movimiento);
                    }

                    $movimiento->refresh();
                //}

                $movimiento->pendiente = false;

                $movimiento->save();

            //     echo $movimiento->id . ' - ' . $movimiento->cantidad . ' => ' . $this->posicionesCortas($movimiento->activo, $movimiento->broker)->count() . ' => ' . $this->posicionesLargas($movimiento->activo, $movimiento->broker)->count() . "\n";
            }

            elseif ($movimiento->clase == 'Venta') 
            {
                while ($movimiento->remanente) 
                {
                    if ($posicion_a_cerrar = $this->posicionesLargas($movimiento->activo, $movimiento->broker)->first()) 
                    {
                        if (isset($this->ejercicios[$movimiento->id]))
                        {
                            dump($movimiento);
                        }

                        $this->cerrarPosicion($posicion_a_cerrar, $movimiento);
                    } 
                    
                    else
                    {
                        $this->crearPosicion(Corta::class, $movimiento);
                    }

                    $movimiento->refresh();
                }

                $movimiento->pendiente = false;

                $movimiento->save();

            //     echo $movimiento->id . ' - ' . $movimiento->cantidad . ' => ' . $this->posicionesCortas($movimiento->activo, $movimiento->broker)->count() . ' => ' . $this->posicionesLargas($movimiento->activo, $movimiento->broker)->count() . "\n";
            }
        }
    }

    // private function posicionesCortas(Activo $activo, Broker $broker)
    // {
    //     return Posicion::cortas()->abiertas()->byActivo($activo)->byBroker($broker)->byApertura();
    // }

    private function posicionesLargas(Activo $activo, Broker $broker)
    {
        return Larga::abiertas()->byActivo($activo)->byBroker($broker)->byApertura();
    }

    private function crearPosicion($clase, Movimiento $movimiento, $cantidad_solicitada = 0)
    {
        if (!$cantidad_remanente = abs($movimiento->cantidad) - $movimiento->cantidad_imputada) 
        {
            die('Chau');

            return null;
        }

        if ($cantidad_solicitada > $cantidad_remanente) 
        {
            die("Error en la cantidad solicitada");
        }

        $posicion = $clase::create([
            'fecha_apertura'     => $movimiento->fecha_operacion,
            'estado'             => 'Abierta',
            'activo_id'          => $movimiento->activo_id,
            'broker_id'          => $movimiento->broker_id,
            'moneda_original_id' => $movimiento->moneda_original_id
        ]);

        $this->primerMovimiento($posicion, $movimiento, $cantidad_solicitada ?: $cantidad_remanente);

        return $posicion;
    }

    private function primerMovimiento(Posicion $posicion, Movimiento $movimiento, $cantidad_solicitada)
    {
        $posicion->cantidad = $cantidad_solicitada;

        $ponderador_movimiento = $cantidad_solicitada / abs($movimiento->cantidad);

        $posicion->save();

        $this->agregarMovimiento($posicion, $movimiento, $cantidad_solicitada, $ponderador_movimiento);
    }

    private function agregarMovimiento(Posicion $posicion, Movimiento $movimiento, $cantidad_solicitada, $ponderador_movimiento)
    {
        $posicion->movimientos()->create([
            'movimiento_id'                     => $movimiento->id,
            'cantidad'                          => $cantidad_solicitada,
            'moneda_original_id'                => $movimiento->moneda_original_id,
            'precio_en_moneda_original'         => $movimiento->precio_en_moneda_original,
            'monto_parcial_en_moneda_original'  => $ponderador_movimiento * $movimiento->monto_en_moneda_original,
            'precio_en_dolares'                 => $movimiento->precio_en_dolares,
            'monto_parcial_en_dolares'          => $ponderador_movimiento * $movimiento->monto_en_dolares,
            'precio_en_pesos'                   => $movimiento->precio_en_pesos,
            'monto_parcial_en_pesos'            => $ponderador_movimiento * $movimiento->monto_en_pesos,
        ]);

        $movimiento->cantidad_imputada += $cantidad_solicitada;

        $movimiento->save();
    }

    private function sumarMovimiento(Posicion $posicion, Movimiento $movimiento, $cantidad_solicitada)
    {
        if ($cantidad_remanente = abs($movimiento->cantidad) - $movimiento->cantidad_imputada) 
        {
            if ($cantidad_solicitada > $cantidad_remanente) 
            {
                die("Error en la cantidad solicitada");
            }

            $cantidad_original = $posicion->cantidad;

            $posicion->cantidad += $cantidad_solicitada;

            $ponderador_original = $cantidad_original / $posicion->cantidad;

            $ponderador_remanente = $cantidad_solicitada / $posicion->cantidad;

            $ponderador_movimiento = $cantidad_solicitada / abs($movimiento->cantidad);

            $posicion->save();

            $posicion->movimientos()->create([
                'movimiento_id'                     => $movimiento->id,
                'cantidad'                          => $cantidad_solicitada,
                'moneda_original_id'                => $movimiento->moneda_original_id,
                'precio_en_moneda_original'         => $movimiento->precio_en_moneda_original,
                'monto_parcial_en_moneda_original'  => $ponderador_movimiento * $movimiento->monto_en_moneda_original,
                'precio_en_dolares'                 => $movimiento->precio_en_dolares,
                'monto_parcial_en_dolares'          => $ponderador_movimiento * $movimiento->monto_en_dolares,
                'precio_en_pesos'                   => $movimiento->precio_en_pesos,
                'monto_parcial_en_pesos'            => $ponderador_movimiento * $movimiento->monto_en_pesos,
            ]);

            $movimiento->cantidad_imputada += $cantidad_solicitada;

            $movimiento->save();
        }

        return $this;
    }

    private function cerrarPosicion(Posicion $posicion, Movimiento $movimiento, $cantidad_solicitada = null)
    {
        if (!$cantidad_remanente = (abs($movimiento->cantidad) - $movimiento->cantidad_imputada)) 
        {
            return null;
        }

        if (!$cantidad_solicitada) 
        {
            $cantidad_solicitada = $cantidad_remanente;
        }

        if ($cantidad_solicitada > $cantidad_remanente) 
        {
            die("Error en la cantidad solicitada");
        }

        if ($movimiento->remanente < $posicion->cantidad) 
        {
            $this->split($posicion, $movimiento->remanente);

            $posicion->refresh();

            //dd($posicion);
        }

        if ($movimiento->remanente >= $posicion->cantidad) 
        {
            $ponderador = $posicion->cantidad / abs($movimiento->cantidad);

            $posicion->fecha_cierre = $movimiento->fecha_operacion;

            $posicion->estado = 'Cerrada';

            $posicion->save();

            $this->agregarMovimiento($posicion, $movimiento, $posicion->cantidad, $ponderador);

            return;
        }

        if ($movimiento->remanente > $posicion->cantidad) 
        {
            dd('Hay que cerrar la posicion usando parcialmente el movimiento');
        }

        dump($movimiento->remanente);
    }

    private function split(Posicion $posicion, $cantidad)
    {
        /*  Esta funcion divide una posicion en dos posiciones. 
            La primera de esas posiciones, que conserva el id de la original, contiene $cantidad
            La nueva posicion, contiene el resto de las cantidades
        */

        $cantidad_nueva = $posicion->cantidad - $cantidad;

        $ponderador = $cantidad / $posicion->cantidad;

        $nueva_posicion = $posicion->replicate();

        $nueva_posicion->cantidad = $cantidad_nueva;

        $nueva_posicion->save();

        $posicion->cantidad = $cantidad;

        $posicion->save();
        
        foreach($posicion->movimientos as $movimiento)
        {
            $nueva_posicion->movimientos()->create([
                'movimiento_id'                     => $movimiento->movimiento_id,
                'cantidad'                          => $cantidad_nueva,
                'moneda_original_id'                => $movimiento->moneda_original_id,
                'precio_en_moneda_original'         => $movimiento->precio_en_moneda_original,
                'monto_parcial_en_moneda_original'  => $movimiento->monto_parcial_en_moneda_original * (1 - $ponderador),
                'precio_en_dolares'                 => $movimiento->precio_en_dolares,
                'monto_parcial_en_dolares'          => $movimiento->monto_parcial_en_dolares * (1 - $ponderador),
                'precio_en_pesos'                   => $movimiento->precio_en_pesos,
                'monto_parcial_en_pesos'            => $movimiento->monto_parcial_en_pesos * (1 - $ponderador),
            ]);
    
            $movimiento->fill([
                'cantidad'                          => $cantidad,
                'monto_parcial_en_moneda_original'  => $movimiento->monto_parcial_en_moneda_original * $ponderador,
                'monto_parcial_en_dolares'          => $movimiento->monto_parcial_en_dolares * $ponderador,
                'monto_parcial_en_pesos'            => $movimiento->monto_parcial_en_pesos * $ponderador,
            ]);

            $movimiento->save();
        }
    }

    protected $ejercicios = [];

    protected function detectarEjerciciosCall()
    {
        foreach(Ejercicio::all() as $ejercicio)
        {
            /*
                Un ejercicio debe estar acompañado de la venta del activo y de la compra de la opción realizadas ese mismo dia
            */

            $venta = Venta::where('fecha_operacion', $ejercicio->fecha_operacion)->get();

            if (count($venta) != 1)
            {
                die('No se pudo localizar la venta y/o existen varias ventas para el mismo día');
            }

            $call = Movimiento::where('fecha_operacion', $ejercicio->fecha_operacion)->where('cantidad', $venta[0]->cantidad / 100)->get();

            if (count($call) != 1)
            {
                die('No se pudo localizar la anulación del call y/o existen varios ejercicios para el mismo día');
            }

            $this->ejercicios[$venta[0]->id] = [$ejercicio->id, $call[0]->id];
        }
    }
}
