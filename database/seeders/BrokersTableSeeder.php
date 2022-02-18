<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Broker;

class BrokersTableSeeder extends Seeder
{
    public function run()
    {
        Broker::create([
            'nombre' => 'Invertir On Line',
            'sigla' => 'IOL'
        ]);

        Broker::create([
            'nombre' => 'Portfolio Personal Inversiones',
            'sigla' => 'PPI'
        ]);

        Broker::create([
            'nombre' => 'Bell Investments',
            'sigla' => 'BELL'
        ]);

        Broker::create([
            'nombre' => 'Afluenta',
            'sigla' => 'AF'
        ]);

        Broker::create([
            'nombre' => 'Okex',
            'sigla' => 'OKEX'
        ]);

        Broker::create([
            'nombre' => 'Stone X Finantial',
            'sigla' => 'SX'
        ]);
    }
}
