<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class CreateNotificacionesTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::NOTIFICACIONES, function (Blueprint $table) 
        {
            $table->increments('id');
            $table->text('origen');
            $table->text('ticker');
            $table->text('accion');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::NOTIFICACIONES);
    }
}