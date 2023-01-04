<?php

namespace App\Models\Contables;

use Illuminate\Database\Eloquent\Model;
use App\Config\Constantes as Config;
use App\Models\Movimientos\Movimiento;
use App\Models\Cuenta;
use App\Models\Activos\Moneda;

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

    public function getAportesNetosAttribute($value)
    {
        return $this->aportes - $this->retiros;
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
            $saldo = 0;

            foreach($this->getCuentasEnDolaresAttribute() as $cuenta)
            {
                $saldo += $cuenta->saldo;
            }
    
            // $this->cuentas_saldo_en_dolares = \App\Actions\Calcular\CalcularSaldoDeCajaEnDolaresAction::do($this->fecha);

            $this->cuentas_saldo_en_dolares = $saldo;

            $this->save();
        }

        return $this->attributes['cuentas_saldo_en_dolares'];
    }

    
    public function getCuentasEnDolaresAttribute()
    {
        return Cuenta::conSaldos($this->fecha)
            ->whereIn('sigla', ['PPIccl', 'PPIg', 'SX'])
            ->get();

        $moneda = Moneda::where('denominacion', 'like', 'Dolar Americano')->first();

        return Cuenta::conSaldos($this->fecha)
            ->where('moneda_id', $moneda->id)
            ->get();
    }
}