<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Esteban Rogel',
            'email' => 'estebanrogel@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
