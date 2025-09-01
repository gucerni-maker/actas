<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plantillas_actas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['desarrollo', 'produccion']);
            $table->text('texto_introduccion')->nullable();
            $table->text('texto_confidencialidad')->nullable();
            $table->text('encabezado_personalizado')->nullable();
            $table->text('pie_personalizado')->nullable();
            $table->json('campos_requeridos')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plantillas_actas');
    }
};
