<?php

namespace App\Actions\Importar;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use League\Csv\Reader;
use App\Models\Broker;
use App\Models\Cuenta;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;
use App\Models\Activos\Adr;
use App\Models\Activos\Call;
use App\Models\Activos\Ticker;
use App\Models\Movimientos\Comision;
use App\Models\Movimientos\Compra;
use App\Models\Movimientos\Deposito;
use App\Models\Movimientos\Dividendo;
use App\Models\Movimientos\Movimiento;
use App\Models\Movimientos\Recepcion;
use App\Models\Movimientos\Venta;

class ImportarDatosDePpiAction extends Base
{
    protected $broker = 'PPI';

    // protected $archivos = ['Movimientos 01.xlsx', 'Movimientos 2019.xlsx', 'Movimientos 2020.xlsx', 'Movimientos 2021.xlsx', 'Movimientos 2022.xlsx', 'Movimientos 2022-04-07-09-12-37.xlsx'];

    protected $archivos = ['Movimientos 2024-07-08-12-11-58.xlsx'];

    protected function setCuenta($planilla)
    {
        if ($planilla == 'Pesos')
        {
            return $this->cuenta = Cuenta::bySigla('PPIpesos');
        }

        elseif ($planilla == 'Dolares CV 7000')
        {
            return $this->cuenta = Cuenta::bySigla('PPI7000');
        }

        elseif ($planilla == 'Dolar MEP - COM 7340')
        {
            return $this->cuenta = Cuenta::bySigla('PPI7340');
        }

        elseif ($planilla == 'Dolar CV10000')
        {
            return $this->cuenta = Cuenta::bySigla('PPI10000');
        }

        elseif ($planilla == 'Dolar MEP')
        {
            return $this->cuenta = Cuenta::bySigla('PPImep');
        }

        elseif ($planilla == 'Dolar Cable')
        {
            return $this->cuenta = Cuenta::bySigla('PPIccl');
        }

        elseif ($planilla == 'Instrumentos')
        {
            return $this->cuenta = Cuenta::bySigla('PPIins');
        }

        elseif ($planilla == 'Dolar PPI Global')
        {
            return $this->cuenta = Cuenta::bySigla('PPIg');
        }

        elseif ($planilla == 'Euro CV')
        {
            return $this->cuenta = Cuenta::bySigla('PPIeuro');
        }

        dd($planilla);
    }

    protected function fecha_operacion($datos): ?Carbon
    {
        return $this->fecha($datos, 'A');
    }

    protected function fecha_liquidacion($datos): ?Carbon
    {
        return null;
    }

    protected function valida($datos): ?String
    {
    	return true;
    }

    protected function observaciones($datos): ?String
    {
    	return trim($datos['B']);
    }

    protected function activo($datos): ?Activo
    {
        $o = $this->observaciones($datos);

        if (Str::contains($o, 'Call'))
        {
            $partes = explode('\\', $o);

            if (count($partes) == 2)
            {
                if ($activo = Activo::where('simbolo', 'LIKE', trim($partes[1]))->first())
                {
                    return $activo;
                }

                $padre = substr(trim($partes[1]), 0, 3);

                $principal = Ticker::byName($padre);

                return Call::create([
                    'denominacion' => trim($partes[1]),
                    'simbolo'      => trim($partes[1]),
                    'principal_id' => $principal ? $principal->activo->id : null
                ]);
            }
    
            return null;
        }

        $partes = explode(' ', $o);

        if (count($partes) == 2)
        {
            if ($t = Ticker::byName(trim($partes[1])))
            {
                return $t->activo;
            }

            // dd(trim($partes[1]));
        }

    	return null;
    }

    protected function numero_operacion($datos): ?String
    {
    	return null;
    }

    protected function numero_boleto($datos): ?String
    {
        return null;
    }

    protected function tipo_operacion($datos): ?String
    {
    	if (Str::startsWith($this->observaciones($datos), 'Ingreso de Fondos')) 
        {
        	return static::OP_DEPOSITO;
        }

    	if (Str::startsWith($this->observaciones($datos), 'Retiro de Fondos')) 
        {
        	return static::OP_RETIRO;
        }

        if (Str::startsWith($this->observaciones($datos), 'COMPRA '))
        {
        	return static::OP_COMPRA;
        }

        if (Str::startsWith($this->observaciones($datos), 'Compra Call '))
        {
        	return static::OP_COMPRA;
        }

        if (Str::startsWith($this->observaciones($datos), 'VENTA '))
        {
        	return static::OP_VENTA;
        }

        if (Str::startsWith($this->observaciones($datos), 'Venta Call '))
        {
        	return static::OP_VENTA;
        }

        return null;
    }

    protected function cantidad($datos): ?float
    {
    	return $this->toFloat($datos['C']) 
            ? abs($this->toFloat($datos['C']))
            : null;
    }

    protected function precio_en_moneda_original($datos): ?float
    {
        $valor = $this->toFloat($datos['D']);

        if ($activo = $this->activo($datos))
        {   
            if ($activo->clase == 'Bono')
            {
                return $valor ? $valor * 100 : null;
            }
        }

    	return $valor;
    }

    protected function monto_en_moneda_original($datos): ?float
    {
    	return $this->toFloat($datos['E']) ?: null;
    }

    protected function comisiones_en_moneda_original($datos): ?float
    {
    	return null;
    }

    protected function iva_en_moneda_original($datos): ?float
    {
    	return null;
    }

    protected function otros_impuestos_en_moneda_original($datos): ?float
    {
    	return null;
    }

    protected function saldo_en_moneda_original($datos): ?float
    {
        return $this->toFloat($datos['F']) ?: null;
    }

    protected function cuenta_corriente($datos, $planilla, $file): ?string
    {
    	return $planilla;
    }
}