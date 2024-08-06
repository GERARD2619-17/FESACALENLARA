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
        Schema::table('partidos', function (Blueprint $table) {
            $table->integer('goles_local')->default(0);
            $table->integer('goles_visitante')->default(0);
            $table->integer('tiempo_transcurrido')->default(0);
            $table->enum('estado', ['no_iniciado', 'primer_tiempo', 'segundo_tiempo', 'finalizado'])->default('no_iniciado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            //
            $table->dropColumn(['goles_local', 'goles_visitante', 'tiempo_transcurrido', 'estado']);
        });
    }
};