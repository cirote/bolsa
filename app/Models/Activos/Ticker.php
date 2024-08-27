<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Ticker extends Model
{
	protected $table = Config::PREFIJO . Config::TICKERS;
	
    protected $fillable = ['ticker'];

    protected $casts = [
        'principal' => 'boolean',
        'precio_referencia_pesos' => 'boolean',
        'precio_referencia_dolares' => 'boolean',
    ];

    static public function byName($name)
    {
        // dump ("Consultando el ticker de {$name}");

        return static::where('ticker', $name)->first();
    }

    protected function activo()
    {
        return $this->belongsTo(Activo::class);
    }
}