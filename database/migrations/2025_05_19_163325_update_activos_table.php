<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Config\Constantes as Config;

class UpdateActivosTable extends Migration
{
    public function up()
    {
        $tableName = Config::PREFIJO . Config::ACTIVOS;

        // Paso 1: Agregar columna 'cotizacion' si no existe
        if (!Schema::hasColumn($tableName, 'cotizacion')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->decimal('cotizacion', 18, 6)->nullable()->after('strike');
            });
        }

        // Paso 2: Eliminar la foreign key de 'principal_id' (sin eliminar la columna)
        // La forma segura es buscar el nombre de la foreign key desde información del schema
        // Si no se conoce el nombre, Laravel le da uno como: table_column_foreign

        // Primero, intentamos eliminar la FK suponiendo el nombre por convención
        Schema::table($tableName, function (Blueprint $table) {
            $table->dropForeign([ 'principal_id' ]);
        });

        // Paso 3: Crear la nueva foreign key con onDelete('cascade')
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            $table->foreign('principal_id')
                  ->references('id')
                  ->on($tableName)
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        $tableName = Config::PREFIJO . Config::ACTIVOS;

        Schema::table($tableName, function (Blueprint $table) {
            // Eliminar FK en cascade
            $table->dropForeign(['principal_id']);
        });

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            // Restaurar FK sin onDelete cascade
            $table->foreign('principal_id')
                  ->references('id')
                  ->on($tableName);
        });

        // Eliminar la columna cotizacion si existe
        if (Schema::hasColumn($tableName, 'cotizacion')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('cotizacion');
            });
        }
    }
}
