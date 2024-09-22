<?php

namespace App\Models\Seguimientos;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;

class Notificacion extends Model
{
    protected $table = Config::PREFIJO . Config::NOTIFICACIONES;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];
}