<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activos\Crypto;

class CryptoTableSeeder extends Seeder
{
    public function run()
    {
        Crypto::create(['denominacion' => 'Bitcoin'])
            ->agregarTicker('BTC');

        Crypto::create(['denominacion' => 'Ethereum'])
            ->agregarTicker('ETH');

        Crypto::create(['denominacion' => 'Tether'])
            ->agregarTicker('USDT');
    }
}
