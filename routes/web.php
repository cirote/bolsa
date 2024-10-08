<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () 
{
    return view('welcome');
});

Route::get('/test', function () 
{
    return view('test');
});

Route::middleware(['auth:sanctum', 'verified'])
    ->group(function () 
    {
        Route::controller(\App\Http\Controllers\DashboardController::class)
        ->group(function () 
        {
            Route::get('/dashboard', 'index')->name('dashboard');
        });

        Route::controller(\App\Http\Controllers\RecomendacionesController::class)
        ->group(function () 
        {
            Route::get('/recomendaciones', \App\Http\Livewire\Recomendaciones\Index::class)->name('recomendaciones');
        });

        Route::controller(\App\Http\Controllers\ActivosController::class)
            ->prefix('activos')
            ->name('activos.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Activos\Index::class)->name('index');
            });

        Route::prefix('trading')
            ->name('trading.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Trading\Index::class)->name('index');
                Route::get('/{activo}', \App\Http\Livewire\Trading\Activo::class)->name('activo');
            });

        Route::prefix('cuentas')
            ->name('cuentas.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Cuentas\Index::class)->name('index');
                Route::get('/saldos', \App\Http\Livewire\Cuentas\Saldos::class)->name('saldos');
            });

        Route::controller(\App\Http\Controllers\GrillasController::class)
            ->prefix('grillas')
            ->name('grillas.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Grillas\Index::class)->name('index');
                Route::get('/{grilla}', \App\Http\Livewire\Grillas\Bandas::class)->name('bandas');
            });

        Route::controller(\App\Http\Controllers\BrokerController::class)
            ->prefix('broker')
            ->name('broker.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::post('/', 'store')->name('store');
            });

        Route::controller(\App\Http\Controllers\MovimientosController::class)
            ->prefix('movimientos')
            ->name('movimientos.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Movimientos\Index::class)->name('index');
                Route::get('/{cuenta}', 'show')->name('show');
            });

        Route::controller(\App\Http\Controllers\PosicionesController::class)
            ->prefix('posiciones')
            ->name('posiciones.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
                Route::get('/corto', 'corto_index')->name('corto.index');
            });

        Route::prefix('operaciones')
            ->name('operaciones.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Operaciones\Index::class)->name('index');
            });

        Route::controller(\App\Http\Controllers\GlobalesController::class)
            ->prefix('globales')
            ->name('globales.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
            });

        Route::controller(\App\Http\Controllers\SeguimientosController::class)
            ->prefix('seguimientos')
            ->name('seguimientos.')
            ->group(function () 
            {
                Route::get('/', \App\Http\Livewire\Seguimientos\Index::class)->name('index');
            });

        Route::controller(\App\Http\Controllers\EstadosController::class)
            ->prefix('estados')
            ->name('estados.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
            });

        Route::controller(\App\Http\Controllers\ResultadosController::class)
            ->prefix('resultados')
            ->name('resultados.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
                Route::get('/{resultado}', 'show')->name('show');
            });
});
