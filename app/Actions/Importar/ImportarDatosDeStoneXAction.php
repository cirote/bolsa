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
use App\Models\Movimientos\Dividendo;
use App\Models\Movimientos\Ejercicio;
use App\Models\Movimientos\Movimiento;
use App\Models\Movimientos\Recepcion;
use App\Models\Movimientos\Venta;

class ImportarDatosDeStoneXAction
{
    protected $broker;

    protected $cuenta;

    protected $file;

    protected $csv;

    static public function do(string $file)
    {
        return new static($file);
    }

    public function __construct($file)
    {
        $this->file = $file;

        $this->broker = Broker::bySigla('SX');

        $this->cuenta = Cuenta::bySigla('SX');

        $this->crear_reader();

        $this->borrar_datos_anteriores();

        $this->import();
    }

    protected function crear_reader()
    {
        $this->csv = Reader::createFromPath(storage_path('app/historico/NYSE/SX/') . $this->file, 'r');

        $this->csv->setHeaderOffset(0);
    }

    protected function borrar_datos_anteriores()
    {
        Movimiento::where('archivo', $this->file)->delete();
    }

    protected function import()
    {
        $registros = [];

        foreach($this->csv->getRecords() as $record)
        {
            array_unshift($registros, $record);
        }

        foreach($registros as $record)
        {
            //  dump($record);

            if (Str::startsWith($record["Action"], 'Sell'))
            {
                $clase = Venta::class;
            }

            elseif (Str::startsWith($record["Action"], 'Buy'))
            {
                $clase = Compra::class;
            }

            elseif (Str::startsWith($record["Transaction Type"], 'Dividends and Interest'))
            {
                $clase = Dividendo::class;
            }

            elseif (Str::startsWith($record["Transaction Type"], 'ReceiveNDeliver'))
            {
                //  dump($record);

                $clase = Recepcion::class;
            }

            elseif (Str::startsWith($record["Transaction Type"], 'ExerciseNExpiration') OR Str::startsWith($record["Transaction Description"], 'OPTION EXERCISE'))
            {
                //  dump($record);

                $clase = Ejercicio::class;
            }

            elseif ((double) $record["Amount"])
            {
                //  dump($record);

                $clase = Comision::class;
            }

            else
            {
                //  dump($record);

                $clase = Movimiento::class;
            }

            $activo = $this->crear_activo($record["CUSIP"] ?? null, $record["Transaction Description"], $record["Symbol / ID"]);

            $clase::create([
                'cuenta_id'         => $this->cuenta->id,
                'fecha_operacion'   => Carbon::create($record["Trade Date"]),
                'fecha_liquidacion' => Carbon::create($record["Settle Date"]),
                'numero_operacion'  => $record["Control No"],
                'broker_id'         => $this->broker->id,
                'activo_id'         => $activo ? $activo->id : null,
                'observaciones'     => $record["Transaction Description"] ?: 'Vacio',
                'cantidad'          => abs((double) $record["Quantity"]),
                
                'moneda_original_id' => Ticker::byName('USD')->activo->id,

                'precio_en_moneda_original' => (double) $record["Price"],
                'precio_en_dolares' => (double) $record["Price"],
                'monto_en_moneda_original' => (double) $record["Amount"],
                'monto_en_dolares'  => (double) $record["Amount"],
                'archivo'           => $this->file
            ]);

        }
    }

    protected function crear_activo($cusip, $denominacion, $simbolo)
    {
        $denominacion = trim(Str::replace('  ', ' ', $denominacion));

        for ($i = 1; $i <= 3; $i++)
        {
            $simbolo = trim(Str::replace('  ', ' ', $simbolo));
        }

        if ($denominacion == 'BEYOND MEAT INC')
        {
            $cusip = '08862E109';
        }

        elseif ($denominacion == 'ITAU UNIBANCO HOLDING SA SPONSORED ADR REPRESENTING 500 PFD')
        {
            $cusip = '465562106';
        }

        elseif ($denominacion == 'META PLATFORMS INC CL A')
        {
            $cusip = '30303M102';
        }

        elseif ($denominacion == 'NETFLIX INC')
        {
            $cusip = '64110L106';
        }

        if (! $cusip)
        {
            if (! $simbolo)
            {
                if ($activo = Activo::where('denominacion', 'LIKE', $denominacion)->first())
                {
                    return $activo;
                }
        
                return null;
            }

            $principal = Ticker::byName(Str::substr($simbolo, 0, 3));

            return Call::firstOrCreate([
                'simbolo'      => $simbolo
            ], [
                'cusip'        => $cusip,
                'denominacion' => $denominacion,
                'principal_id' => $principal ? $principal->activo->id : null
            ]);
        }

        if ($activo = Activo::where('cusip', $cusip)->first())
        {
            return $activo;
        }

        return Adr::create([
            'cusip'        => $cusip,
            'denominacion' => $denominacion,
            'simbolo'      => $simbolo
        ]);
    }
}