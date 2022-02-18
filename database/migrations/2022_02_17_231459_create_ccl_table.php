<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class CreateCclTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::CCL, function (Blueprint $table) 
        {
            $table->id();
            $table->date('fecha')->unique();
            $table->double('argentina_pesos');
            $table->double('argentina_dolares');
            $table->double('extranjero_dolares');
            $table->double('mep');
            $table->double('ccl');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::CCL);
    }
}
