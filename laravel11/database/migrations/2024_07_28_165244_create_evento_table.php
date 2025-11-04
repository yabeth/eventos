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
        Schema::create('evento', function (Blueprint $table) {
            $table->integer('idevento', true);
            $table->string('eventnom', 45);
            $table->integer('idTipoeven')->index('fk_idtipeven');
            $table->integer('idestadoeve')->nullable()->index('fk_idestado');
            $table->string('descripción', 45)->nullable();
            $table->time('horain')->nullable();
            $table->time('horcul')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento');
    }
};
