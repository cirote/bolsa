<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class CreateCompraventasTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::COMPRAVENTAS, function (Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('operacion_compra_id')->unsigned()->nullable()->default(null);
            $table->foreign('operacion_compra_id')->references('id')->on(Config::PREFIJO . Config::OPERACIONES);

            $table->integer('operacion_venta_id')->unsigned()->nullable()->default(null);
            $table->foreign('operacion_venta_id')->references('id')->on(Config::PREFIJO . Config::OPERACIONES);

            $table->integer('cantidad')->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::COMPRAVENTAS);
    }
}