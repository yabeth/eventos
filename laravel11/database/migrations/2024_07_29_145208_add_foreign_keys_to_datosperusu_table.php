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
        Schema::table('datosperusu', function (Blueprint $table) {
            $table->foreign(['idpersona'], 'fk_idperson')->references(['idpersona'])->on('personas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idusuario'], 'fk_idusua')->references(['idusuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datosperusu', function (Blueprint $table) {
            $table->dropForeign('fk_idperson');
            $table->dropForeign('fk_idusua');
        });
    }
};
