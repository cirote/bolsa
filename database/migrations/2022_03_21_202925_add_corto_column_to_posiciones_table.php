<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class AddCortoColumnToPosicionesTable extends Migration
{
    public function up()
    {
        Schema::table(Config::PREFIJO . Config::POSICIONES, function (Blueprint $table) 
        {
            $table->boolean('corto_plazo')->after('moneda_original_id')->default(false);
        });
    }

    public function down()
    {
        Schema::table(Config::PREFIJO . Config::POSICIONES, function (Blueprint $table) 
        {
            $table->dropColumn('corto_plazo');
        });
    }
}
