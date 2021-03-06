<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class CreateActivosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::ACTIVOS, function (Blueprint $table) 
        {
            $table->increments('id');

            $table->char('cusip', 9)->index()->nullable()->default(null);

            $table->char('denominacion', 255)->index();
            $table->string('clase')->nullable();
            $table->string('type')->nullable();

            $table->integer('principal_id')->unsigned()->nullable()->default(null);
            $table->foreign('principal_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->double('strike')->nullable()->default(null);
            $table->date('vencimiento')->nullable()->default(null);

            $table->boolean('ccl')->default(false);

            $table->char('simbolo', 50)->unique()->nullable()->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::ACTIVOS);
    }
}