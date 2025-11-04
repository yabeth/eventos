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
        Schema::create('informe', function (Blueprint $table) {
            $table->integer('idinforme', true);
            $table->dateTime('fecpres');
            $table->string('tipoinf', 45);
            $table->text('rta');
            $table->integer('idcertificacn')->index('fk_idcertifn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informe');
    }
};
