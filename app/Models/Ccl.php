<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Config\Constantes as Config;
use App\Models\Activos\Ticker;

class Ccl extends Model
{
    protected $table = Config::PREFIJO . Config::CCL;

    protected $guarded = [];

    static public function byDate($date = null)
    {
        $date = static::getDate($date);

        if ($model = static::where('fecha', $date->format('Y-m-d'))->first())
        {
            return $model;
        }

        if ($date->lessThan(Carbon::create(2012, 8, 1)))
        {
            return null;
        }

        if ($date->lessThan(Carbon::create(2019, 9, 1)))
        {
            $h_usa = static::getHistorico('TS', 'NYSE', $date);

            $h_arg = static::getHistorico('TS', 'BCBA', $date);

            if ($h_usa AND $h_arg)
            {
                $arg = $h_arg->cierre;

                $usa = $h_usa->cierre;

                $rel = 1;
            }

            else
            {
                return static::byDate($date->subDays(1));
            }
        }

        if ($date->lessThan(Carbon::create(2022, 3, 1)))
        {
            $h_usa = static::getHistorico('GGAL', 'NYSE', $date);

            $h_arg = static::getHistorico('GGAL', 'BCBA', $date);

            if ($h_usa AND $h_arg)
            {
                $arg = $h_arg->cierre;

                $usa = $h_usa->cierre;

                $rel = 10;
            }

            else
            {
                return static::byDate($date->subDays(1));
            }
        }

        else 
        {
            $arg = static::getCotizacion('GGAL.BA', $date);

            $usa = static::getCotizacion('GGAL', $date);

            $rel = 10;
        }

        return static::create([
            'fecha' => $date,
            'argentina_pesos' => $arg,
            'argentina_dolares' => 0,
            'extranjero_dolares' => $usa,
            'mep' => 0,
            'ccl' => $arg / $usa * $rel
        ]);
    }

    static public function getHistorico(string $ticker, string $mercado, Carbon $date)
    {
        $activo = Ticker::byName($ticker);

        $mercado = Mercado::bySigla($mercado);

        return Historico::where('activo_id', $activo->id)
            ->where('mercado_id', $mercado->id)
            ->where('fecha', $date->format('Y-m-d'))
            ->first();
    }

    static public function getDate($date = null): Carbon
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

        return $date;
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