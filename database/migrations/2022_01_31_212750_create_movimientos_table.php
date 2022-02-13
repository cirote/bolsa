<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class CreateMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::MOVIMIENTOS, function (Blueprint $table) 
        {
            $table->increments('id');

            $table->string('clase')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->date('fecha');

            $table->integer('activo_id')->unsigned()->nullable()->default(null);
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->integer('broker_id')->unsigned();
            $table->foreign('broker_id')->references('id')->on(Config::PREFIJO . Config::BROKERS);
            
            $table->string('descripcion')->nullable();
            $table->bigInteger('cantidad')->nullable()->default(null);
            $table->double('precio')->nullable()->default(null);
            $table->double('pesos')->nullable()->default(null);
            $table->double('dolares');

            $table->string('archivo')->nullable()->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::MOVIMIENTOS);
    }
}