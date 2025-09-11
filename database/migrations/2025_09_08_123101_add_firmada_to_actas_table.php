<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->boolean('firmada')->default(false)->after('es_acta_existente');
        });
    }

    public function down()
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->dropColumn('firmada');
        });
    }
};