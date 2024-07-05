<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
use App\Config\Constantes as Config;
use App\Models\Activos\Activo;
use App\Models\Movimientos\Movimiento;

class Operacion extends Model
{
    use HasChildren;

    protected $table = Config::PREFIJO . Config::OPERACIONES;

    protected $guarded = [];

    protected $dates = ['fecha'];

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
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

    public function scopeConMonto(Builder $query)
    {
        return $query->addSelect([
            'monto' => Movimiento::selectRaw('SUM(monto_en_dolares)')
                ->whereColumn('operacion_id', $file = Config::PREFIJO . Config::OPERACIONES . '.id'),
            'cantidad' => Movimiento::selectRaw('SUM(cantidad)')
                ->whereColumn('operacion_id', $file),
            'fecha' => Movimiento::selectRaw('MIN(fecha_operacion)')
                ->whereColumn('operacion_id', $file),
            'elementos' => Movimiento::selectRaw('count(*)')
                ->whereColumn('operacion_id', $file),
        ]);
    }
}