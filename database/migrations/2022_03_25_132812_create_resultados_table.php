<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class CreateResultadosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::RESULTADOS, function (Blueprint $table) 
        {
            $table->id();
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->double('resultado_en_pesos')->nullable()->default(null);
            $table->double('resultado_en_dolares')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::RESULTADOS);
    }
}
