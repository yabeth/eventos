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
        Schema::create('inscripción', function (Blueprint $table) {
            $table->integer('idincrip', true);
            $table->integer('idescuela')->index('fk_idescu');
            $table->integer('idpersona')->index('fk_idperso');
            $table->integer('idevento')->index('fk_ideventos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripción');
    }
};
