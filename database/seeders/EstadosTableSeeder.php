<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contables\Estado;

class EstadosTableSeeder extends Seeder
{
    public function run()
    {
        Estado::create([
            'fecha' => '2021-12-31'
        ]);

        Estado::create([
            'fecha' => '2022-01-31'
        ]);

        Estado::create([
            'fecha' => '2022-02-28'
        ]);

        Estado::create([
            'fecha' => '2022-03-31'
        ]);

        Estado::create([
            'fecha' => '2022-04-30'
        ]);
    }
}
