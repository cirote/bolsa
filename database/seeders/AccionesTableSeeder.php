<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activos\Accion;

class AccionesTableSeeder extends Seeder
{
    public function run()
    {
        Accion::create([
            'denominacion' => 'Carboclor S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('CARC.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('CARC', 'Acción', 1, 1);

        Accion::create([
            'cusip'  => '05964H105',
            'denominacion' => 'Banco Santander S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SAN', 'ADR', 1, 1, 0, 1)
            ->agregarTicker('SAN', 'Acción', 1, 0, 1);

        Accion::create([
            'cusip'  => '465562106',
            'denominacion' => 'ITAU Unibanco S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('ITUB', 'ADR', 1, 1, 0, 1)
            ->agregarTicker('ITUB', 'CEDEAR', 1, 0, 1);

        Accion::create([
            'cusip'  => '71654V408',
            'denominacion' => 'Petrobras S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('APBR', 'Acción', 0.5, 0, 1)
            ->agregarTicker('PBR', 'ADR', 1, 1, 0, 1);

        Accion::create([
            'denominacion' => 'Ternium Argentina S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('TXAR', 'Acción', 1, 1)
            ->agregarTicker('TXAR.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('ERAR', 'Acción', 1);

        Accion::create([
            'denominacion' => 'Grupo Financiero Galicia S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('GGAL', 'ADR', 10, 1, 0, 1)
            ->agregarTicker('GFG', 'Base')
            ->agregarTicker('GFG.BA', 'Acción', 1, 0, 1, 0);

        Accion::create([
            'denominacion' => 'Banco Supervielle S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SUPV', 'ADR', 5, 1, 0, 1)
            ->agregarTicker('SUPV.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('SUPV', 'Acción', 1);

        Accion::create([
            'denominacion' => 'Tenaris S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('TS', 'ADR', 1, 1, 0, 1)
            ->agregarTicker('TS', 'Acción');

        Accion::create([
            'denominacion' => 'Phoenix Global Resources (ex Andes Energia)',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('PGR', 'Acción', 1, 1)
            ->agregarTicker('PGR.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('AEN');

        Accion::create([
            'denominacion' => 'Yacimientos Petroliferos Fiscales S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('YPF', 'ADR', 1, 0, 0, 1)
            ->agregarTicker('YPFD.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('YPFD', 'Acción', 1, 1);

        Accion::create([
            'denominacion' => 'Meta Platforms, Inc.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('FB', 'Acción', 1, 1, 0, 1);
    
        Accion::create([
            'cusip'  => '931142103',
            'denominacion' => 'Waltmart Inc.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('WMT', 'Acción', 1, 1, 0, 1);
    
        Accion::create([
            'denominacion' => 'MercadoLibre Inc.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('MELI', 'Acción', 1, 1, 0, 1);
    }
}
