<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuenta;
use App\Models\Broker;
use App\Models\Activos\Ticker;

class CuentasTableSeeder extends Seeder
{
    public function run()
    {
        Cuenta::create([
            'nombre' => 'IOL Pesos',
            'sigla' => 'IOLpesos',
            'broker_id' => Broker::bySigla('IOL')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'IOL CCL',
            'sigla' => 'IOLccl',
            'broker_id' => Broker::bySigla('IOL')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'IOL MEP',
            'sigla' => 'IOLmep',
            'broker_id' => Broker::bySigla('IOL')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'PPI Pesos',
            'sigla' => 'PPIpesos',
            'broker_id' => Broker::bySigla('PPI')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'PPI CCL',
            'sigla' => 'PPIccl',
            'broker_id' => Broker::bySigla('PPI')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'PPI MEP',
            'sigla' => 'PPImep',
            'broker_id' => Broker::bySigla('PPI')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'BELL Pesos',
            'sigla' => 'IOLpesos',
            'broker_id' => Broker::bySigla('BELL')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'BELL CCL',
            'sigla' => 'BELLccl',
            'broker_id' => Broker::bySigla('BELL')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'BELL MEP',
            'sigla' => 'BELLmep',
            'broker_id' => Broker::bySigla('BELL')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'Afluenta Pesos',
            'sigla' => 'AFpesos',
            'broker_id' => Broker::bySigla('AF')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'SX Dolares',
            'sigla' => 'SX',
            'broker_id' => Broker::bySigla('SX')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'OKEX Dolares',
            'sigla' => 'OKusd',
            'broker_id' => Broker::bySigla('OKEX')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'OKEX Tether',
            'sigla' => 'OKusdt',
            'broker_id' => Broker::bySigla('OKEX')->id,
            'moneda_id' => Ticker::byName('USDT')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'OKEX Bitcoin',
            'sigla' => 'OKbtc',
            'broker_id' => Broker::bySigla('OKEX')->id,
            'moneda_id' => Ticker::byName('BTC')->activo->id
        ]);

        Cuenta::create([
            'nombre' => 'OKEX Ethereum',
            'sigla' => 'OKeth',
            'broker_id' => Broker::bySigla('OKEX')->id,
            'moneda_id' => Ticker::byName('ETH')->activo->id
        ]);
    }
}
