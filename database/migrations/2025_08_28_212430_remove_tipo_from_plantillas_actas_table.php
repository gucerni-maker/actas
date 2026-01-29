<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plantillas_actas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }

    public function down()
    {
        Schema::table('plantillas_actas', function (Blueprint $table) {
            $table->enum('tipo', ['desarrollo', 'produccion'])->default('desarrollo');
        });
    }
};
