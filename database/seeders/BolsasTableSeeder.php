<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bolsa;

class BolsasTableSeeder extends Seeder
{
    public function run()
    {
        Bolsa::create([
            'nombre' => 'Bolsa de Comercio de Buenos Aires',
            'sigla' => 'BCBA'
        ]);

        Bolsa::create([
            'nombre' => 'New York Stock Exchange',
            'sigla' => 'NYSE'
        ]);

        Bolsa::create([
            'nombre' => 'National Association of Securities Dealers Automated Quotation',
            'sigla' => 'NASDAQ'
        ]);

        Bolsa::create([
            'nombre' => 'Binance',
            'sigla' => 'BIN'
        ]);

        Bolsa::create([
            'nombre' => 'Okex',
            'sigla' => 'OKEX'
        ]);
    }
}
