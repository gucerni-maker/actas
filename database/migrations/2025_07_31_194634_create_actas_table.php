<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('actas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_entrega');
            $table->text('observaciones')->nullable();
            $table->string('archivo_pdf')->nullable();
            
            // Claves foráneas
            $table->unsignedBigInteger('programador_id');
            $table->unsignedBigInteger('servidor_id');
            $table->unsignedBigInteger('usuario_id');
            
            // Relaciones
            $table->foreign('programador_id')->references('id')->on('programadores')->onDelete('cascade');
            $table->foreign('servidor_id')->references('id')->on('servidores')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actas');
    }
};
