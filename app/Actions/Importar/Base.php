<?php

namespace App\Actions\Importar;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use League\Csv\Reader;
use App\Models\Broker;
use App\Models\Ccl;
use App\Models\Cuenta;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;
use App\Models\Activos\Adr;
use App\Models\Activos\Call;
use App\Models\Activos\Moneda;
use App\Models\Activos\Ticker;
use App\Models\Movimientos\Comision;
use App\Models\Movimientos\Compra;
use App\Models\Movimientos\Deposito;
use App\Models\Movimientos\Ejercicio;
use App\Models\Movimientos\Dividendo;
use App\Models\Movimientos\Extraccion;
use App\Models\Movimientos\Movimiento;
use App\Models\Movimientos\Recepcion;
use App\Models\Movimientos\Venta;

abstract class Base
{
    const DOLAR_MEP = 'Dolar MEP';

    const DOLAR_CABLE = 'Dolar Cable';

    const DOLAR_PPI_GLOBAL = 'Dolar PPI Global';

    const DOLAR_7000 = 'Dolares CV 7000';

    const PESOS = 'Pesos';

    const ADMINISTRADA_PESOS = 'Administrada Pesos';

    const OP_DEPOSITO = 'Deposito';

    const OP_EJERCICIO = 'Ejercicio';

    const OP_RETIRO = 'Extraccion';

    const OP_COMPRA = 'Compra';

    const OP_VENTA = 'Venta';

    const OP_COMISION = 'Comision';

    protected $cuenta;

    static public function do($archivo = null)
    {
        return (new static($archivo))->execute();
    }

    public function execute()
    {
        $this->cargarDatos();
    }

    protected $darVuelta = false;

    protected $peso;

    protected $dolar;

    protected $archivos = [];

    public function __construct($archivo)
    {
        if ($archivo)   
        {
            $this->archivos = [$archivo];
        }

        $this->peso = Ticker::byName('$')->activo;

        $this->dolar = Ticker::byName('USD')->activo;
    }

    protected function leerLibro($file)
    {
        $url = storage_path("app/historico/BCBA/{$this->getBroker()->sigla}/{$file}");

        if (!file_exists($url)) 
        {
            throw new \error("El archivo [$url] no existe");
        }

        $reader = IOFactory::createReaderForFile($url);

        $reader->setReadDataOnly(true);

        return $reader->load($url);
    }

    private $_broker;

    protected function getBroker(): Broker
    {
        if (! $this->_broker) 
        {
            $this->_broker = Broker::bySigla($this->broker);
        }

        return $this->_broker;
    }

    protected function cargarDatos()
    {
        foreach ($this->archivos as $archivo) 
        {
            $this->migrarArchivo($archivo);
        }
    }

    protected function migrarArchivo($file)
    {
        ini_set('memory_limit', '256M'); 

        $libro = $this->leerLibro($file);

        $planillas = $libro->getSheetNames();

        foreach ($planillas as $planilla) 
        {
            $this->setCuenta($planilla);

            $datos = $libro->getSheetByName($planilla)->toArray(null, true, true, true);

            if ($this->darVuelta) 
            {
                $datos = array_reverse($datos, true);
            }

            foreach ($datos as $dato) 
            {
                $this->migrate($dato, $planilla, $file);
            }
        }
    }

    protected function migrate($renglon, $planilla, $file)
    {
        $datos = $this->getDatos($renglon, $planilla, $file);

        if ($this->datos_validos($datos)) 
        {
            unset($datos['valida']);

            $tipo_operacion = $datos['tipo_operacion'];

            unset($datos['tipo_operacion']);


            if ($tipo_operacion == static::OP_DEPOSITO)
            {
                Deposito::create($datos);                
            }

            elseif ($tipo_operacion == static::OP_RETIRO)
            {
                Extraccion::create($datos);                
            }

            elseif ($tipo_operacion == static::OP_COMPRA)
            {
                Compra::create($datos);                
            }

            elseif ($tipo_operacion == static::OP_VENTA)
            {
                Venta::create($datos);                
            }

            elseif ($tipo_operacion == static::OP_COMISION)
            {
                Comision::create($datos);                
            }

            elseif ($tipo_operacion == static::OP_EJERCICIO)
            {
                Ejercicio::create($datos);                
            }

            else
            {
                Movimiento::create($datos);                
            }
        }
    }

    protected function getDatos($renglon, $planilla, $file)
    {
        return [
            'fecha_operacion'   => $this->fecha_operacion($renglon),
            'fecha_liquidacion' => $this->fecha_liquidacion($renglon),

            'activo_id'  => $this->activo($renglon) ? $this->activo($renglon)->id : null,

            'numero_operacion' => $this->numero_operacion($renglon),
            'numero_boleto'    => $this->numero_boleto($renglon),
            'tipo_operacion'   => $this->tipo_operacion($renglon),

            'cantidad' => $this->cantidad($renglon),

            'moneda_original_id' => $this->moneda_original($renglon, $planilla, $file) ? $this->moneda_original($renglon, $planilla, $file)->id : null,

            'precio_en_moneda_original'      => $this->precio_en_moneda_original($renglon),
            'monto_en_moneda_original'       => $this->monto_en_moneda_original($renglon),
            'comisiones_en_moneda_original'  => $this->comisiones_en_moneda_original($renglon),
            'iva_en_moneda_original'         => $this->iva_en_moneda_original($renglon),
            'otros_impuestos_en_moneda_original'  => $this->otros_impuestos_en_moneda_original($renglon),
            'saldo_en_moneda_original'       => $this->saldo_en_moneda_original($renglon),

            'precio_en_dolares' => $this->precio_en_dolares($renglon, $planilla, $file),
            'monto_en_dolares'  => $this->monto_en_dolares($renglon, $planilla, $file),

            'precio_en_pesos' => $this->precio_en_pesos($renglon, $planilla, $file),
            'monto_en_pesos'  => $this->monto_en_pesos($renglon, $planilla, $file),

            'broker_id' => $this->getBroker()->id,

            'cuenta_corriente' => $this->cuenta_corriente($renglon, $planilla, $file),

            'archivo'   => $file,
            'hoja'      => $planilla,

            'observaciones' => $this->observaciones($renglon),

            'valida' => $this->valida($renglon),

            'cuenta_id'         => $this->cuenta ? $this->cuenta->id : null,
        ];
    }

    protected function datos_validos($datos)
    {
        if (!$datos['valida']) 
        {
            dump('Sin valida');

            return false;
        }

        if (!$datos['fecha_operacion']) 
        {
            dump('Sin fecha de operacion');

            return false;
        }

        if (!$datos['monto_en_moneda_original']) 
        {
            dump('Sin moneda original');

            return false;
        }

        return true;
    }

    protected function tofloat($num)
    {
        $signo = (strpos($num, '-') !== false) ? -1 : 1; 

        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) 
        {
            return $signo * abs(floatval(preg_replace("/[^0-9]/", "", $num)));
        }

        $float = floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
                preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
        );

        return $signo * abs($float);
    }

    protected function precio_en_dolares($datos, $planilla, $file): ?float
    {
        return $this->en_dolares(
            $this->precio_en_moneda_original($datos),
            $this->moneda_original($datos, $planilla, $file),
            $this->fecha_operacion($datos)
        );
    }

    protected function monto_en_dolares($datos, $planilla, $file): ?float
    {
        return $this->en_dolares(
            $this->monto_en_moneda_original($datos),
            $this->moneda_original($datos, $planilla, $file),
            $this->fecha_operacion($datos)
        );
    }

    protected function en_dolares($dato_original, $moneda_original, $fecha): ?float
    {
        if (!$dato_original)
            return null;

        if (!$moneda_original)
            return null;

        if ($moneda_original->id == $this->dolar->id) 
        {
            return $dato_original;
        }

        if ($moneda_original->id == $this->peso->id) 
        {
            return $dato_original / Ccl::byDate($fecha)->ccl;
        }

        return -1;
    }

    protected function precio_en_pesos($datos, $planilla, $file): ?float
    {
        return $this->en_pesos(
            $this->precio_en_moneda_original($datos),
            $this->moneda_original($datos, $planilla, $file),
            $this->fecha_operacion($datos)
        );
    }

    protected function monto_en_pesos($datos, $planilla, $file): ?float
    {
        return $this->en_pesos(
            $this->monto_en_moneda_original($datos),
            $this->moneda_original($datos, $planilla, $file),
            $this->fecha_operacion($datos)
        );
    }

    protected function en_pesos($dato_original, $moneda_original, $fecha): ?float
    {
        if (!$dato_original)
            return null;

        if (!$moneda_original)
            return null;

        if ($moneda_original->id == $this->dolar->id) 
        {
            return $dato_original * Ccl::byDate($fecha)->ccl;
        }

        $peso = Ticker::byName('$')->activo;

        if ($moneda_original->id == $this->peso->id) 
        {
            return $dato_original;
        }

        return -1;
    }

    protected function fecha($datos, $celda): ?Carbon
    {
        $fecha = trim($datos[$celda]);

        $patron = "/[a-zA-Z]/";

        if (preg_match($patron, $fecha))
            return null;

        if (is_numeric($fecha))
        {
            $fecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha);
        }

        if ($fecha instanceof \DateTime)
    	{
    		return Carbon::instance($fecha);
    	}

        if (strlen($fecha) == 8) 
        {
            return Carbon::createFromFormat("d/m/y H:i:s", $fecha . ' 00:00:00');
        }

        if (strlen($fecha) == 10) 
        {
            return Carbon::createFromFormat("d/m/Y H:i:s", $fecha . ' 00:00:00');
        }

        return null;
    }

    protected function moneda_original($datos, $planilla, $file)
    {
        switch ($this->cuenta_corriente($datos, $planilla, $file)) 
        {
            case static::DOLAR_MEP:
            case static::DOLAR_CABLE:
            case static::DOLAR_PPI_GLOBAL:
            case static::DOLAR_7000:
                return $this->dolar;

            case static::PESOS:
            case static::ADMINISTRADA_PESOS:
                return $this->peso;

            default:
                return null;
        }
    }

    abstract protected function setCuenta($planilla);

    abstract protected function cantidad($datos): ?float;

    abstract protected function cuenta_corriente($datos, $planilla, $file): ?string;

    abstract protected function fecha_operacion($datos): ?Carbon;

    abstract protected function fecha_liquidacion($datos): ?Carbon;

    abstract protected function activo($datos): ?Activo;

    abstract protected function monto_en_moneda_original($datos): ?float;

    abstract protected function precio_en_moneda_original($datos): ?float;

    abstract protected function iva_en_moneda_original($datos): ?float;

    abstract protected function otros_impuestos_en_moneda_original($datos): ?float;

    abstract protected function numero_operacion($datos): ?String;

    abstract protected function numero_boleto($datos): ?String;

    abstract protected function tipo_operacion($datos): ?String;

    abstract protected function valida($datos): ?String;

    abstract protected function observaciones($datos): ?String;

    abstract protected function comisiones_en_moneda_original($datos): ?float;

    abstract protected function saldo_en_moneda_original($datos): ?float;
}
