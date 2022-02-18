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

        return 'jeje';
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