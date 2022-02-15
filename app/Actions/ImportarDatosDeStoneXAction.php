<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use League\Csv\Reader;
use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;
use App\Models\Activos\Adr;
use App\Models\Activos\Call;
use App\Models\Movimientos\Movimiento;

class ImportarDatosDeStoneXAction
{
    protected $broker;

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

        $this->crear_reader();

        $this->borrar_datos_anteriores();

        $this->import();
    }

    protected function crear_reader()
    {
        $this->csv = Reader::createFromPath('/www/wwwroot/bolsa/storage/app/' . $this->file, 'r');

        $this->csv->setHeaderOffset(0);
    }

    protected function borrar_datos_anteriores()
    {
        Movimiento::where('archivo', $this->file)->delete();
    }

    protected function import()
    {
        foreach($this->csv->getRecords() as $record)
        {
            dump($record);

            $activo = $this->crear_activo($record["Cusip"], $record["Description"], $record["Symbol"]);

            Movimiento::create([
                'fecha_operacion'   => Carbon::create($record["TradeDate"]),
                'fecha_liquidacion' => Carbon::create($record["ProcessDate"]),
                'tipo_operacion'    => Str::startsWith($record["Action"], 'Sell') 
                                        ? 'Venta' 
                                        : Str::startsWith($record["Action"], 'Buy') 
                                            ? 'Compra' 
                                            : null,
                'broker_id'         => $this->broker->id,
                'activo_id'         => $activo ? $activo->id : null,
                'observaciones'     => $record["Description"],
                'cantidad'          => abs((double) $record["Quantity"]),
                'precio_en_moneda_original' => (double) $record["Price"],
                'precio_en_dolares' => (double) $record["Price"],
                'monto_en_dolares'  => (double) $record["NetAmount"],
                'archivo'           => $this->file
            ]);

        }
    }

    protected function crear_activo($cusip, $denominacion, $simbolo)
    {
        if (! $cusip)
        {
            if (! $simbolo)
            {
                return null;
            }

            return Call::firstOrCreate([
                'cusip'        => $cusip,
                'denominacion' => $denominacion,
                'simbolo'      => $simbolo
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