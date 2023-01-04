<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contables\Resultado;

class ResultadosTableSeeder extends Seeder
{
    public function run()
    {
        Resultado::create([
            'fecha_inicial' => '2021-12-31',
            'fecha_final'   => '2022-12-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2021-12-31',
            'fecha_final'   => '2022-01-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-01-31',
            'fecha_final'   => '2022-02-28'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-02-28',
            'fecha_final'   => '2022-03-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-03-31',
            'fecha_final'   => '2022-04-30'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-04-30',
            'fecha_final'   => '2022-05-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-05-31',
            'fecha_final'   => '2022-06-30'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-06-30',
            'fecha_final'   => '2022-07-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-07-31',
            'fecha_final'   => '2022-08-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-08-31',
            'fecha_final'   => '2022-09-30'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-09-30',
            'fecha_final'   => '2022-10-31'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-10-31',
            'fecha_final'   => '2022-11-30'
        ]);

        Resultado::create([
            'fecha_inicial' => '2022-11-30',
            'fecha_final'   => '2022-12-31'
        ]);
    }
}
