<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class Grillas extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::GRILLA, function (Blueprint $table) 
        {
            $table->id();
            $table->date('fecha_inicial');
            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);
            $table->double('precio_ultima_operacion')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::GRILLA);
    }
}
