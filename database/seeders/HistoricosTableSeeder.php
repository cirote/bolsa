<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Actions\ImportarTSAction;
use App\Actions\ImportarGGALAction;

class HistoricosTableSeeder extends Seeder
{
    public function run()
    {
        ImportarTSAction::do();

        ImportarGGALAction::do();
    }
}
