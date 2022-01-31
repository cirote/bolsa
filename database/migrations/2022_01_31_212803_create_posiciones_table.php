<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class CreatePosicionesTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::POSICIONES, function (Blueprint $table) 
        {
            $table->id();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::POSICIONES);
    }
}
