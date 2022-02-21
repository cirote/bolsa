<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activos\Moneda;

class MonedasTableSeeder extends Seeder
{
    public function run()
    {
        Moneda::create(['denominacion' => 'Peso Argentino'])
            ->agregarTicker('$')
            ->agregarTicker('$A');

        Moneda::create(['denominacion' => 'Dolar Americano'])
            ->agregarTicker('U$D')
            ->agregarTicker('USD');

        Moneda::create(['denominacion' => 'Peso Uruguayo'])
            ->agregarTicker('$U');
    }
}
