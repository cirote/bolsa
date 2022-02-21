<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activos\Ticker;
use App\Models\Seguimientos\Seguimiento;

class SeguimientosTableSeeder extends Seeder
{
    public function run()
    {
        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'PBR')->first()->activo->id,
            'fecha_1'   => null,
            'fecha_2'   => null,
            'base_1'    => 7,
            'base_2'    => null,
            'amplitud'  => 7,
            'piso'      => 8,
            'techo'     => 13
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'ITUB')->first()->activo->id,
            'fecha_1'   => null,
            'fecha_2'   => null,
            'base_1'    => 3.5,
            'base_2'    => null,
            'amplitud'  => 3.5,
            'piso'      => 4,
            'techo'     => 7
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'SAN')->first()->activo->id,
            'fecha_1'   => null,
            'fecha_2'   => null,
            'base_1'    => 4,
            'base_2'    => null,
            'amplitud'  => 2.5,
            'piso'      => null,
            'techo'     => null
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'GGAL')->first()->activo->id,
            'fecha_1'   => null,
            'fecha_2'   => null,
            'base_1'    => 6,
            'base_2'    => null,
            'amplitud'  => 19,
            'piso'      => null,
            'techo'     => null
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'YPF')->first()->activo->id,
            'fecha_1'   => null,
            'fecha_2'   => null,
            'base_1'    => 4,
            'base_2'    => null,
            'amplitud'  => 11,
            'piso'      => null,
            'techo'     => null
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'WMT')->first()->activo->id,
            'fecha_1'   => '2018-12-24',
            'fecha_2'   => '2020-03-16',
            'base_1'    => 85.67,
            'base_2'    => 102,
            'amplitud'  => 24,
            'piso'      => 0.2,
            'techo'     => 0.8
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'FB')->first()->activo->id,
            'fecha_1'   => '2019-08-19',
            'fecha_2'   => '2020-05-14',
            'base_1'    => 181,
            'base_2'    => 200.63,
            'amplitud'  => 25,
            'piso'      => 0.2,
            'techo'     => 0.8
        ]);

        Seguimiento::create([
            'activo_id' => Ticker::where('ticker', 'MELI')->first()->activo->id,
            'fecha_1'   => '2018-12-24',
            'fecha_2'   => '2020-03-18',
            'base_1'    => 255,
            'base_2'    => 422,
            'amplitud'  => 140,
            'piso'      => 0.2,
            'techo'     => 0.8
        ]);

    }
}
