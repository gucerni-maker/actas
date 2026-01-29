<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->string('comuna')->nullable()->after('usuario_id');
            $table->string('oficina_origen')->nullable()->after('comuna');
            $table->string('oficina_destino')->nullable()->after('oficina_origen');
            $table->text('texto_introduccion')->nullable()->after('oficina_destino');
            $table->text('texto_confidencialidad')->nullable()->after('texto_introduccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->dropColumn(['comuna', 'oficina_origen', 'oficina_destino', 'texto_introduccion', 'texto_confidencialidad']);
        });
    }
};
