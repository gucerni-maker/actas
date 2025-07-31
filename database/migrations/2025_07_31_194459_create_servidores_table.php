<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['desarrollo', 'produccion']);
            $table->string('sistema_operativo');
            $table->string('cpu');
            $table->string('ram');
            $table->string('disco');
            $table->text('notas_tecnicas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servidores');
    }
};
