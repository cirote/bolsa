<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Config\Constantes as Config;

class AddMaximoToActivoTable extends Migration
{
    public function up()
    {
        Schema::table(Config::PREFIJO . Config::ACTIVOS, function (Blueprint $table) 
        {
            $table->double('precio_maximo')->default(0)->after('denominacion');
        });
    }

    public function down()
    {
        Schema::table(Config::PREFIJO . Config::ACTIVOS, function (Blueprint $table) 
        {        
            $table->dropColumn('precio_maximo');
        });
    }
}
