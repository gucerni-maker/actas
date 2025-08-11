<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('programadores', function (Blueprint $table) {
            $table->string('oficina')->nullable()->after('cargo');
            $table->string('departamento')->nullable()->after('oficina');
            $table->string('rut')->unique()->nullable()->after('departamento');
            $table->string('codigo_programador')->nullable()->after('rut');
            
            // Hacer que el campo telefono sea nullable (ya que lo vamos a mantener opcional)
            $table->string('telefono')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('programadores', function (Blueprint $table) {
            $table->dropColumn(['oficina', 'departamento', 'rut', 'codigo_programador']);
        });
    }
};
