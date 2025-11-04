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
        Schema::table('asistencia', function (Blueprint $table) {
            $table->foreign(['idincrip'], 'fk_idinscri')->references(['idincrip'])->on('inscripción')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idtipasis'], 'fk_idtipas')->references(['idtipasis'])->on('tipoasiste')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia', function (Blueprint $table) {
            $table->dropForeign('fk_idinscri');
            $table->dropForeign('fk_idtipas');
        });
    }
};
