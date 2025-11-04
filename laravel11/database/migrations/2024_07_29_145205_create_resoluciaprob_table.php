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
        Schema::create('resoluciaprob', function (Blueprint $table) {
            $table->integer('idreslaprb', true);
            $table->string('nrores', 45);
            $table->dateTime('fechapro');
            $table->integer('idTipresol')->index('fk_idtiresol');
            $table->integer('idevento')->index('fk_idevent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resoluciaprob');
    }
};
