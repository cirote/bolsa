<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Activos\Activo;

class Grilla extends Model
{
    protected $table = Config::PREFIJO . Config::GRILLA;

    protected $guarded = [];

    protected $casts = [
        'fecha_inicial' => 'date:Y-d-m'
    ];

    protected function activo()
    {
        return $this->belongsTo(Activo::class);
    }
}