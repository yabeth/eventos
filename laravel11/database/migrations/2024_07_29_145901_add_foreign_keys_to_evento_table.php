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
        Schema::table('evento', function (Blueprint $table) {
            $table->foreign(['idestadoeve'], 'fk_idestado')->references(['idestadoeve'])->on('estado_evento')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idTipoeven'], 'fk_idtipeven')->references(['idTipoeven'])->on('tipoevento')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento', function (Blueprint $table) {
            $table->dropForeign('fk_idestado');
            $table->dropForeign('fk_idtipeven');
        });
    }
};
