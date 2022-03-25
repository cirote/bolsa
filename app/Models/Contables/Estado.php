<?php

namespace App\Models\Contables;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;
use App\Models\Movimientos\Movimiento;

class Estado extends Model
{
    protected $table = Config::PREFIJO . Config::ESTADOS;

    protected $dates = ['fecha', 'created_at', 'updated_at'];

    protected $guarded = [];

    public function getAportesAttribute($value)
    {
        if ($value === null)
        {
            $this->aportes = \App\Actions\Calcular\CalcularAportesEnDolaresAction::do($this->fecha);

            $this->save();
        }

        return $this->attributes['aportes'];
    }

    public function getRetirosAttribute($value)
    {
        if ($value === null)
        {
            $this->retiros = \App\Actions\Calcular\CalcularRetirosEnDolaresAction::do($this->fecha);

            $this->save();
        }

        return $this->attributes['retiros'];
    }

    public function getInversionAttribute()
    {
        if ($this->monto_invertido_en_dolares === null)
        {
            $this->monto_invertido_en_dolares = \App\Actions\Calcular\CalcularMontoInvertidoEnDolaresAction::do($this->fecha);

            $this->save();
        }

        return $this->attributes['monto_invertido_en_dolares'];
    }

    public function getCuentasSaldoEnPesosAttribute($value)
    {
        if ($value === null)
        {
            $this->cuentas_saldo_en_pesos = \App\Actions\Calcular\CalcularSaldoDeCajaEnPesosAction::do($this->fecha);

            $this->save();
        }

        return $this->attributes['cuentas_saldo_en_pesos'];
    }

    public function getCuentasSaldoEnDolaresAttribute($value)
    {
        if ($value === null)
        {
            $this->cuentas_saldo_en_dolares = \App\Actions\Calcular\CalcularSaldoDeCajaEnDolaresAction::do($this->fecha);

            $this->save();
        }

        return $this->attributes['cuentas_saldo_en_dolares'];
    }
}