<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class CreateMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create(Config::PREFIJO . Config::MOVIMIENTOS, function (Blueprint $table) 
        {
            $table->increments('id');

            $table->string('type')->nullable();

            $table->bigInteger('cuenta_id')->unsigned()->nullable()->default(null);
            $table->foreign('cuenta_id')->references('id')->on(Config::PREFIJO . Config::CUENTAS);

            $table->date('fecha_operacion');
            $table->date('fecha_liquidacion')->nullable()->default(null);

            $table->integer('activo_id')->unsigned()->nullable()->default(null);
            $table->foreign('activo_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->string('tipo_operacion')->nullable()->default(null);
            $table->string('numero_operacion')->nullable()->default(null);
            $table->string('numero_boleto')->nullable()->default(null);
            $table->string('observaciones')->default(null);

            $table->double('cantidad')->nullable()->default(null);
            $table->double('cantidad_imputada')->default(0);

            $table->double('saldo')->default(0);

            $table->integer('moneda_original_id')->unsigned()->nullable()->default(null);
            $table->foreign('moneda_original_id')->references('id')->on(Config::PREFIJO . Config::ACTIVOS);

            $table->decimal('precio_en_moneda_original', 10, 2)->nullable()->default(null);
            $table->decimal('monto_en_moneda_original', 10, 2)->nullable()->default(null);
            $table->decimal('comisiones_en_moneda_original', 10, 2)->nullable()->default(null);
            $table->decimal('iva_en_moneda_original', 10, 2)->nullable()->default(null);
            $table->decimal('otros_impuestos_en_moneda_original', 10, 2)->nullable()->default(null);
            $table->decimal('saldo_en_moneda_original', 10, 2)->nullable()->default(null);
            $table->decimal('saldo_calculado_en_moneda_original', 10, 2)->default(0);

            $table->decimal('precio_en_dolares', 10, 2)->nullable()->default(null);
            $table->decimal('monto_en_dolares', 10, 2)->nullable()->default(null);

            $table->decimal('precio_en_pesos', 10, 2)->nullable()->default(null);
            $table->decimal('monto_en_pesos', 10, 2)->nullable()->default(null);

            $table->integer('broker_id')->unsigned();
            $table->foreign('broker_id')->references('id')->on(Config::PREFIJO . Config::BROKERS);

            $table->string('cuenta_corriente')->nullable()->default(null);

            $table->string('archivo')->nullable()->default(null);
            $table->string('hoja')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Config::PREFIJO . Config::MOVIMIENTOS);
    }
}