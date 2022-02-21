<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activos\Bono;

class BonosTableSeeder extends Seeder
{
    public function run()
    {
        Bono::create([
            'denominacion' => 'Bono Bs.As. Par Largo Plazo U$S 2035',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('BPLD')
            ->agregarTicker('BPLDD')
            ->agregarTicker('BPLDC');

        Bono::create([
            'denominacion' => 'Bono de la Nación Argentina en dólares 8,00% vto. 2020',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('AO20')
            ->agregarTicker('AO20D')
            ->agregarTicker('AO20C');

        Bono::create([
            'denominacion' => 'Bono de la Nación Argentina en dólares 8,75% vto. 2024',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('AY24')
            ->agregarTicker('AY24D')
            ->agregarTicker('AY24C');

        Bono::create([
            'denominacion' => 'Bonos Discount Ley Argentina (U$S) 2033',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('DICA')
            ->agregarTicker('DICAD')
            ->agregarTicker('DICAC');

        Bono::create([
            'denominacion' => 'Bonos Discount Ley Nueva York (U$S) 2033',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('DICY')
            ->agregarTicker('DICYD')
            ->agregarTicker('DICYC');

        Bono::create([
            'denominacion' => 'Bonos Internacionales de la República Argentina en dólares estadounidenses 7,125% 2117',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('AC17')
            ->agregarTicker('AC17D')
            ->agregarTicker('AC17C')
            ->agregarTicker('92610');

        Bono::create([
            'denominacion' => 'Bono de Consolidación Serie 6 2024',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('PR13');

        Bono::create([
            'denominacion' => 'Cupones PBI U$S Ley Argentina',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('TVPA', 'Bono', 1, 1)
            ->agregarTicker('TVPA.BA', 'Bono', 100, 0, 1, 0);
    }
}
