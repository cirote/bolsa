<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Actions\ImportarTSAction;

class HistoricosTableSeeder extends Seeder
{
    public function run()
    {
        ImportarTSAction::do();
    }
}
