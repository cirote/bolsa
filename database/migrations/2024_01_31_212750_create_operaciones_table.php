<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class CreateMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::OPERACIONES, function (Blueprint $table) 
        {
            $table->increments('id');

            $table->string('type')->nullable();

            $table->integer('activo_id')->unsigned()->nullable()->default(null);
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->string('observaciones')->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::OPERACIONES);
    }
}