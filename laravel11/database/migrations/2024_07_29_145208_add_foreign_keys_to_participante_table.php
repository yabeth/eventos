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
        Schema::table('participante', function (Blueprint $table) {
            $table->foreign(['idasistnc'], 'fk_idaistenc')->references(['idasistnc'])->on('asistencia')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participante', function (Blueprint $table) {
            $table->dropForeign('fk_idaistenc');
        });
    }
};
