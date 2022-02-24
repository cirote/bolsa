<?php

namespace App\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use League\Csv\Reader;
use App\Models\Mercado;
use App\Models\Historico;
use App\Models\Activos\Ticker;

class ImportarTSAction
{
    static public function do()
    {
        return (new static())->execute();
    }

    protected $csv;

    protected $activo;

    protected $mercado;

    protected function execute()
    {
        $this->activo = Ticker::byName('TS');

        $this->mercado = Mercado::bySigla('BCBA');

        $this->crear_reader('BCBA/BCBA - 48 hs/TS.csv');

        $this->import();

        $this->mercado = Mercado::bySigla('NYSE');

        $this->crear_reader('NYSE/TS.csv');

        $this->import();
    }

    protected function crear_reader($file)
    {
        $this->csv = Reader::createFromPath(storage_path('app/historico/') . $file, 'r');

        $this->csv->setHeaderOffset(0);
    }

    protected function import()
    {
        foreach($this->csv->getRecords() as $record)
        {
            Historico::create([
                'fecha'      => Carbon::create($record["fecha"]),
                'apertura'   => static::cleanNumber($record["apertura"]),
                'maximo'     => static::cleanNumber($record["maximo"]),
                'minimo'     => static::cleanNumber($record["minimo"]),
                'cierre'     => static::cleanNumber($record["cierre"]),
                'volumen'    => static::cleanNumber($record["volumen"]),
                'interes_abierto' => static::cleanNumber($record["openint"]),
                'mercado_id' => $this->mercado->id,
                'activo_id'  => $this->activo->id
            ]);
        }
    }

    static function cleanNumber($number)
    {
        if (is_numeric($number))
        {
            return $number;
        }

        $number = str_replace(',', '.', $number);

        if (Str::endsWith($number, 'M'))
        {
            $number = substr($number, 0, -1) * 1000000;
        }

        if (Str::endsWith($number, 'K'))
        {
            $number = substr($number, 0, -1) * 1000;
        }

        return (double) $number;
    }
}