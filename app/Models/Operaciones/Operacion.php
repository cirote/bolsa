<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Activos\Activo;

class Operacion extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::OPERACIONES;

    protected $guarded = [];

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function getClaseAttribute()
    {
        $classname = get_class($this);

        if ($pos = strrpos($classname, '\\')) 
        {
            return substr($classname, $pos + 1);
        }

        return $pos;
    }
}