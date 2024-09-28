<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Activos\Activo;

class Seguimiento extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::SEGUIMIENTOS;

    protected $guarded = [];

    protected $casts = [
        'fecha_1' => 'datetime:Y-m-d',
        'fecha_2' => 'datetime:Y-m-d'
    ];

    public $estrategia;

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($seguimiento) 
        {
            $seguimiento->doSomethingAfterHydration();
        });
    }

    protected function doSomethingAfterHydration()
    {
        $modelo = "\\App\\Models\\Seguimientos\\" . $this->tipo;

        $this->estrategia = new $modelo($this);
    }

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function getBaseAttribute()
    {
        return $this->estrategia->base();
    }

    public function getTechoCalculadoAttribute()
    {
        return $this->estrategia->techoCalculado();
    }

    public function getPuntajeAttribute()
    {
        return $this->estrategia->puntaje();
    }

    public function getEstadoAttribute()
    {
        return $this->estrategia->estado();
    }
}