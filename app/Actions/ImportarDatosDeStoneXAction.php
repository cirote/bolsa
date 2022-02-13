<?php

namespace App\Actions;

use Illuminate\Support\Carbon;
use League\Csv\Reader;
use App\Models\Broker;
use App\Models\Movimiento;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;
use App\Models\Activos\Adr;
use App\Models\Activos\Call;

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
                'fecha'       => Carbon::create($record["ProcessDate"]),
                'broker_id'   => $this->broker->id,
                'activo_id'   => $activo ? $activo->id : null,
                'descripcion' => $record["Description"],
                'cantidad'    => (double) $record["Quantity"],
                'precio'      => (double) $record["Price"],
                'dolares'     => (double) $record["NetAmount"],
                'archivo'     => $this->file
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