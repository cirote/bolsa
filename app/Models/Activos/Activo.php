<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Parental\HasChildren;
use App\Config\Constantes as Config;

class Activo extends Model
{
    use HasChildren;

    const CACHE_EN_SEGUNDOS = 120;

    protected $table = Config::PREFIJO . Config::ACTIVOS;

    protected $guarded = [];

    public function getSimboloAttribute()
    {
        if ($ticker = $this->tickers()->where('principal', true)->first())
        {
            return $ticker->ticker;
        }

        return 'n/d';
    }

    private $cotizacion;

    public function getCotizacionAttribute()
    {
        if ($this->cusip == '040114HS2')
        {
            return 0.2608;
        }

        if ($this->denominacion == 'Cupones PBI U$S Ley Argentina')
        {
            return 0.01;
        }

        if (! $this->cotizacion)
        {
            if ($ticker = $this->tickers->where('precio_referencia_dolares', true)->first())
            {
                $this->cotizacion = Cache::remember($ticker->ticker, $this->CACHE_EN_SEGUNDOS, function () use ($ticker)
                {
                    $cliente = \App\Apis\YahooFinanceApi::get();

                    if ($cotizador = $cliente->getQuote($ticker->ticker))
                    {
                        return $cotizador->getRegularMarketPrice();
                    }
        
                    else
                    {
                        return $ticker->ticker;
                    }
                });
            }
    
            elseif ($ticker = $this->tickers->where('precio_referencia_pesos', true)->first())
            {
                $this->cotizacion = Cache::remember($ticker->ticker, $this->CACHE_EN_SEGUNDOS, function () use ($ticker)
                {
                    $cliente = \App\Apis\YahooFinanceApi::get();

                    if ($cotizador = $cliente->getQuote($ticker->ticker))
                    {
                        return $cotizador->getRegularMarketPrice();
                    }
        
                    else
                    {
                        return $ticker->ticker;
                    }
                });
            }
    
            else
            {
                $this->cotizacion = 'n/d';

                $this->cotizacion = 26;
            }
        }

        return $this->cotizacion;
    }

    public function tickers()
    {
        return $this->hasMany(Ticker::class, 'activo_id');
    }

    public function agregarTicker($ticker, $tipo = '', $ratio = 1, $principal = false, $pesos = false, $dolares = false)
    {
        $this->tickers()->firstOrCreate([
            'ticker' => $ticker,
            'tipo' => $tipo,
            'ratio' => $ratio,
            'principal' => $principal,
            'precio_referencia_pesos' => $pesos,
            'precio_referencia_dolares' => $dolares,
        ]);

        return $this;
    }
}