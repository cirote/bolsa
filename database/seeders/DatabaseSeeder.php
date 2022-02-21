<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BrokersTableSeeder::class);
        $this->call(AccionesTableSeeder::class);
        $this->call(BonosTableSeeder::class);
        $this->call(CryptoTableSeeder::class);
        $this->call(MonedasTableSeeder::class);
        $this->call(SeguimientosTableSeeder::class);
    }
}
