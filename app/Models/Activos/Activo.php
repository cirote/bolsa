<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Operaciones\Compraventa;
use App\Models\Operaciones\Operacion;

class Activo extends Model
{
    use HasChildren;

    const CACHE_EN_SEGUNDOS = 300;

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
                $this->cotizacion = Cache::remember($ticker->ticker, self::CACHE_EN_SEGUNDOS, function () use ($ticker)
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
                $this->cotizacion = Cache::remember($ticker->ticker, self::CACHE_EN_SEGUNDOS, function () use ($ticker)
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

    static public function toOptions()
    {
        return self::whereIn('type', ['App\Models\Activos\Accion'])
            ->orderBy('denominacion')
            ->pluck('denominacion', 'id')
            ->map(function ($descripcion, $id) 
            { 
                return "{$id}:{$descripcion}"; 
            }
        )->implode('|');
    }

    public function tickers()
    {
        return $this->hasMany(Ticker::class, 'activo_id');
    }

    public function operaciones()
    {
        return $this->hasMany(Operacion::class);
    }

    public function compras()
    {
        return $this->operaciones()->where('type', 'App\Models\Operaciones\Compra');
    }

    public function ventas()
    {
        return $this->operaciones()->where('type', 'App\Models\Operaciones\Venta');
    }

    public function dividendos()
    {
        return $this->operaciones()->where('type', 'App\Models\Operaciones\Dividendo');
    }

    public function compraventas()
    {
        return $this->hasManyThrough(Compraventa::class, Operacion::class, 'activo_id', 'operacion_compra_id');
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