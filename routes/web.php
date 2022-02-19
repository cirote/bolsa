<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () 
{
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () 
{
    return view('dashboard');

})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
    ->group(function () 
    {
        Route::controller(\App\Http\Controllers\ActivosController::class)
            ->prefix('activos')
            ->name('activos.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
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
                Route::get('/', 'index')->name('index');
            });

        Route::controller(\App\Http\Controllers\PosicionesController::class)
            ->prefix('posiciones')
            ->name('posiciones.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
            });

            Route::controller(\App\Http\Controllers\SeguimientosController::class)
            ->prefix('seguimientos')
            ->name('seguimientos.')
            ->group(function () 
            {
                Route::get('/', 'index')->name('index');
            });
    });
