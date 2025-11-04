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
        Schema::create('datosperusu', function (Blueprint $table) {
            $table->integer('idusuario')->index('fk_idusua');
            $table->integer('idpersona')->index('fk_idperson');
            $table->integer('idatosPer', true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datosperusu');
    }
};
