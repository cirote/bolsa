<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class CreateSeguimientosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::SEGUIMIENTOS, function (Blueprint $table) 
        {
            $table->id();

            $table->integer('activo_id')->unsigned();
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->string('type')->nullable();

            $table->date('fecha_1')->nullable()->default(null);
            $table->date('fecha_2')->nullable()->default(null);

            $table->double('base_1');
            $table->double('base_2')->nullable()->default(null);

            $table->double('amplitud');

            $table->double('piso')->nullable()->default(null);
            $table->double('techo')->nullable()->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::SEGUIMIENTOS);
    }
}
