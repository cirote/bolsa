<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use App\Config\Constantes as Config;

class Activo extends Model
{
    use HasChildren;

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

    public function getCotizacionAttribute()
    {
        if ($ticker = $this->tickers()->where('precio_referencia_dolares', true)->first())
        {
            $cliente = \App\Apis\YahooFinanceApi::get();

            if ($cotizador = $cliente->getQuote($ticker->ticker))
            {
                return $cotizador->getRegularMarketPrice();
            }

            return $ticker->ticker;
        }

        if ($ticker = $this->tickers()->where('precio_referencia_pesos', true)->first())
        {
            $cliente = \App\Apis\YahooFinanceApi::get();

            if ($cotizador = $cliente->getQuote($ticker->ticker))
            {
                return $cotizador->getRegularMarketPrice() / \App\Models\Ccl::byDate()->ccl;
            }

            return $ticker->ticker;
        }

        return 'n/d';
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