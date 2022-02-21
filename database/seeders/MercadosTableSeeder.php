<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bolsa;
use App\Models\Mercado;
use App\Models\Activos\Ticker;

class MercadosTableSeeder extends Seeder
{
    public function run()
    {
        Mercado::create([
            'nombre' => 'BCBA en pesos 24 horas',
            'sigla' => 'BCBA24',
            'bolsa_id' => Bolsa::bySigla('BCBA')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Mercado::create([
            'nombre' => 'BCBA en pesos 48 horas',
            'sigla' => 'BCBA48',
            'bolsa_id' => Bolsa::bySigla('BCBA')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Mercado::create([
            'nombre' => 'BCBA en pesos plazo normal',
            'sigla' => 'BCBA',
            'bolsa_id' => Bolsa::bySigla('BCBA')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Mercado::create([
            'nombre' => 'BCBA en pesos contado',
            'sigla' => 'BCBA24CTD',
            'bolsa_id' => Bolsa::bySigla('BCBA')->id,
            'moneda_id' => Ticker::byName('$A')->activo->id
        ]);

        Mercado::create([
            'nombre' => 'NYSE en dolares plazo normal',
            'sigla' => 'NYSE',
            'bolsa_id' => Bolsa::bySigla('NYSE')->id,
            'moneda_id' => Ticker::byName('USD')->activo->id
        ]);
    }
}
