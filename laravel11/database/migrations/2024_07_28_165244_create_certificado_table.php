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
        Schema::create('certificado', function (Blueprint $table) {
            $table->integer('idCertif', true);
            $table->string('nro', 45);
            $table->integer('idcertificacn')->index('fk_idtipceti');
            $table->integer('idestcer')->index('fk_idiestcert');
            $table->integer('idparti')->index('fk_idpart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificado');
    }
};
