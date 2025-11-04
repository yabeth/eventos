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
        Schema::table('inscripción', function (Blueprint $table) {
            $table->foreign(['idescuela'], 'fk_idescu')->references(['idescuela'])->on('escuela')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idevento'], 'fk_ideventos')->references(['idevento'])->on('evento')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idpersona'], 'fk_idperso')->references(['idpersona'])->on('personas')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripción', function (Blueprint $table) {
            $table->dropForeign('fk_idescu');
            $table->dropForeign('fk_ideventos');
            $table->dropForeign('fk_idperso');
        });
    }
};
