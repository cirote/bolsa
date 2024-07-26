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

    public static function conStock()
    {
        $activos_validos = Operacion::query()
            ->select('activo_id')
            ->distinct()
            ->get()
            ->pluck('activo_id');

        $activos = Activo::whereIn('id', $activos_validos);

        $activos->orderBy('denominacion');

        $activos = $activos->get();

        return $activos->filter(function ($activo) 
        {
            return $activo->stock != 0;
        });
    }

    public function getEstadoAttribute()
    {
        $bajo = -100 * ($this->maximo - $this->cotizacion) / ($this->maximo ? $this->maximo : 1);

        $resultado = $this->inversion ? $this->resultadosNoRealizados / $this->inversion * 100 : 0;

        if($bajo < -0.05 AND $resultado > 20)
        {
            return 'Vender';
        }

        return '';
    }

    public function getSimboloAttribute()
    {
        if ($ticker = $this->tickers()->where('principal', true)->first())
        {
            return $ticker->ticker;
        }

        return 'n/d';
    }

    public function getMaximoAttribute()
    {
        if ($this->getCotizacionAttribute() > $this->precio_maximo)
        {
            $this->precio_maximo = $this->getCotizacionAttribute();

            $this->save();
        }

        return $this->precio_maximo;
    }

    public function getDividendosCobradosAttribute()
    {
        return abs($this->dividendos->sum('monto'));
    }

    public function getInversionAttribute()
    {
        return abs($this->compras->sum('inversion'));
    }

    public function getResultadosCompraVentaAttribute()
    {
        return abs($this->ventas->sum('monto')) - abs($this->compras->sum('monto')) + $this->inversion;
    }

    public function getResultadosRealizadosAttribute()
    {
        return $this->resultadosCompraVenta + $this->dividendosCobrados;
    }

    public function getResultadosNoRealizadosAttribute()
    {
        return abs(($this->getCotizacionAttribute() * $this->stock)) - $this->getInversionAttribute();
    }

    public function getResultadosTotalesAttribute()
    {
        return $this->resultadosRealizados + $this->resultadosNoRealizados;
    }

    public function getStockAttribute()
    {
        return abs($this->compras->sum('cantidad')) - abs($this->ventas->sum('cantidad'));
    }

    public function getPPCAttribute()
    {
        return $this->stock
            ? $this->inversion / $this->stock
            : 0;
    }

    private $cotizacion;

    public function getCotizacionAttribute()
    {
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

                $this->cotizacion = $this->ppc;
            }
        }

        return $this->cotizacion;
    }

    static public function toOptions()
    {
        return self::whereIn('type', ['App\Models\Activos\Accion', 'App\Models\Activos\Etf'])
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