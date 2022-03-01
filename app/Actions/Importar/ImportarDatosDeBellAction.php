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

class ImportarDatosDeBellAction extends Base
{
    protected $darVuelta = true;

	protected $broker = 'BELL';

    protected $archivos = ['Hasta 2019.xlsx', 'Pesos 2020-2021.xlsx', 'Dolar 2020-2021.xlsx'];

    protected function setCuenta($planilla)
    {

    }

    protected function fecha_operacion($datos): ?Carbon
    {
        return $this->fecha($datos, 'C');
    }

    protected function fecha_liquidacion($datos): ?Carbon
    {
        return $this->fecha($datos, 'B');
    }

    protected function valida($datos): ?String
    {
    	return true;
    }

    protected function observaciones($datos): ?String
    {
    	return strlen($obs = trim($datos['K']))
            ? $obs
            : trim($datos['F']);
    }

    protected function activo($datos): ?Activo
    {
        $observaciones = $this->observaciones($datos);

        if ($activo = Ticker::byName($this->nombreTicker($datos)))
        {
            return $activo->activo;
        }

        if (Str::contains($observaciones, ['(C)']))
        {
            return Call::firstOrCreate([
                'cusip'        => null,
                'denominacion' => $observaciones,
                'simbolo'      => $observaciones
            ]);
        }

        return null;
    }

    protected function nombreTicker($datos)
    {
        $nombre = trim($datos['F'] ?? 'XXXX');

        if (strlen($nombre) == 4)
        {
            return $nombre;
        }

        return [
            'BANCO SANTANDER C.H.'                  => 'SAN',
            'BONO REP ARGENTINA 7,125% 28/06/2117'  => 'AC17',
            'BPLD - PROV BSAS 2035 4% USD'          => 'BPLD',
            'CARBOCLOR SA'                          => 'CARC',
            'CEDEAR PETROLEO BRASILEIRO'            => 'PBR',
            'DICA BONO DISCOUNT U$S 8,28% 2033'     => 'DICA',
            'DICY BONO DISCOUNT U$S 8,28% 2033'     => 'DICY',
            'GRUPO FIN.GALICIA'                     => 'GGAL',
            'GRUPO SUPERVIELLE ACC.ORD. "B" 1'      => 'SUPV',
            'PHOENIX GLOBAL RESOURCES PLC. ORD SHS' => 'PGR',
            'TERNIUM ARG S.A.ORDS. A 1 VOTO ESC'    => 'TXAR',
            'TVPA VAL.NEG. PBI 2035'                => 'TVPA',
            'YPF S.A.'                              => 'YPFD',
        ][$nombre] ?? null;
    }

    protected function numero_operacion($datos): ?String
    {
    	$operacion = trim($datos['E']);

    	if ($operacion == '0')
    		return null;

    	return $operacion;
    }

    protected function numero_boleto($datos): ?String
    {
    	return null;
    }

    protected function tipo_operacion($datos): ?String
    {
        return [
            'COBR' => static::OP_DEPOSITO,
            'PAU$' => static::OP_RETIRO,
            'CPRA' => static::OP_COMPRA,
            'COPR' => static::OP_COMPRA,
            'CPU$' => static::OP_COMPRA,
            'SUSC' => static::OP_COMPRA,
            'VTAS' => static::OP_VENTA,
            'VTPR' => static::OP_VENTA,
//            'EJPV' => static::OP_VENTA,
        ][trim($datos['D'])] ?? null;
    }

    protected function cantidad($datos): ?float
    {
    	return $this->toFloat($datos['G']) ?: null;
    }

    protected function precio_en_moneda_original($datos): ?float
    {
    	return $this->toFloat($datos['H']) ?: null;
    }

    protected function monto_en_moneda_original($datos): ?float
    {
    	return $this->toFloat($datos['I']) ?: null;
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
        return $this->toFloat($datos['J']) ?: null;
    }

    protected function cuenta_corriente($datos, $planilla, $file): ?string
    {
    	if ($planilla == 'Dolar')
        {
            $this->cuenta = Cuenta::bySigla('BELLmep');

            return static::DOLAR_MEP;
        }
    		
    	if ($planilla == 'Pesos')
        {
            $this->cuenta = Cuenta::bySigla('BELLpesos');

            return static::PESOS;
        }
    		
        if (Str::startsWith($file, 'Dolar'))
        {
            $this->cuenta = Cuenta::bySigla('BELLmep');

            return static::DOLAR_MEP;
        } 

        if (Str::startsWith($file, 'Pesos'))
        {
            $this->cuenta = Cuenta::bySigla('BELLpesos');

            return static::PESOS;
        }
            
        $this->cuenta = null;

    	return 'Cuenta Inexistente';
    }
}