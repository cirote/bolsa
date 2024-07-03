<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class AddOperacionesColumnToMovimientosTable extends Migration 
{
    public function up()
    {
        Schema::table(Config::PREFIJO . Config::MOVIMIENTOS, function (Blueprint $table) 
        {
            $table->boolean('operacion_principal')->default(false)->after('pendiente');
            $table->unsignedInteger('operacion_id')->nullable()->default(null)->after('pendiente');
            $table->foreign('operacion_id')->references('id')->on(Config::PREFIJO . Config::OPERACIONES);
        });
    }

    public function down()
    {
        Schema::table(Config::PREFIJO . Config::MOVIMIENTOS, function (Blueprint $table) 
        {
            $table->dropForeign(Config::PREFIJO . Config::MOVIMIENTOS . '_operacion_id_foreign');
            $table->dropColumn('operacion_id');
            $table->dropColumn('operacion_principal');
        });
    }
}
