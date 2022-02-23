<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class CreateCuentasTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::CUENTAS, function (Blueprint $table) 
        {
            $table->id();

            $table->string('nombre');
            $table->string('sigla');

            $table->integer('broker_id')->index()->unsigned();
            $table->foreign('broker_id')->references('id')->on(Config::PREFIJO . Config::BROKERS);

            $table->integer('moneda_id')->unsigned();
            $table->foreign('moneda_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::CUENTAS);
    }
}
