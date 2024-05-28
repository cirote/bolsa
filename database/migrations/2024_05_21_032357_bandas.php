<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class Bandas extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::BANDAS, function (Blueprint $table) 
        {
            $table->increments('id');
            $table->date('fecha_operacion');
            $table->boolean('estado');
            $table->integer('grilla_id')->unsigned();
            $table->foreign('grilla_id')->references('id')->on(Config::PREFIJO . Config::GRILLA);
            $table->double('precio')->nullable()->default(null);
            $table->double('precio_operacion')->nullable()->default(null);
            $table->double('monto')->nullable()->default(null);
            $table->integer('cantidad')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::BANDAS);
    }
}
