<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Config\Constantes as Config;

class Ccl extends Model
{
    protected $table = Config::PREFIJO . Config::CCL;

    protected $guarded = [];

    static public function byDate($date = null)
    {
        if (! $date instanceof Carbon)
        {
            if (! $date)
            {
                $date = Carbon::now();
            }

            else
            {
                $date = Carbon::parse($date);
            }
        }

        if ($model = static::where('fecha', $date->format('Y-m-d'))->first())
        {
            return $model;
        }

        $ggal_arg = static::getCotizacion('GGAL.BA', $date);

        $ggal_usa = static::getCotizacion('GGAL', $date);

        return static::create([
            'fecha' => $date,
            'argentina_pesos' => $ggal_arg,
            'argentina_dolares' => 0,
            'extranjero_dolares' => $ggal_usa,
            'mep' => 0,
            'ccl' => $ggal_arg / $ggal_usa * 10
        ]);
    }

    static private function getCotizacion($simbolo, $date)
    {
        $cliente = \App\Apis\YahooFinanceApi::get();

        if ($cotizador = $cliente->getQuote($simbolo))
        {
            return $cotizador->getRegularMarketPrice();
        }
    }
}