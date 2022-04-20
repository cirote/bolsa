<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Broker;
use App\Models\Activos\Activo;

class Resultado extends Model
{
    protected $table = Config::PREFIJO . Config::RESULTADOS;

    protected $guarded = [];

    protected $dates = [
        'fecha_inicial',
        'fecha_final'
    ];

}