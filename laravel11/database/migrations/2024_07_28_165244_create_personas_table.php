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
        Schema::create('personas', function (Blueprint $table) {
            $table->integer('idpersona', true);
            $table->string('dni', 8);
            $table->string('nombre', 45);
            $table->string('apell', 45);
            $table->string('tele', 11);
            $table->string('email', 45);
            $table->string('direc', 45);
            $table->integer('idgenero')->index('fk_idgen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
