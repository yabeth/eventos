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
        Schema::create('escuela', function (Blueprint $table) {
            $table->integer('idescuela', true);
            $table->string('nomescu', 45);
            $table->integer('idfacultad')->index('fk_idfacu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escuela');
    }
};
