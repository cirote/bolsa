<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class CreateEstadosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::ESTADOS, function (Blueprint $table) 
        {
            $table->id();
            $table->date('fecha')->unique();
            $table->double('aportes')->nullable()->default(null);
            $table->double('retiros')->nullable()->default(null);
            $table->double('cuentas_saldo_en_pesos')->nullable()->default(null);
            $table->double('cuentas_saldo_en_dolares')->nullable()->default(null);
            $table->double('monto_invertido_en_pesos')->nullable()->default(null);
            $table->double('monto_invertido_en_dolares')->nullable()->default(null);
            $table->double('tir')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::ESTADOS);
    }
}
