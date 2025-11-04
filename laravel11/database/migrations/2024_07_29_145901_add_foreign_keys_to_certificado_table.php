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
        Schema::table('certificado', function (Blueprint $table) {
            $table->foreign(['idestcer'], 'fk_idiestcert')->references(['idestcer'])->on('estadocerti')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idparti'], 'fk_idpart')->references(['idparti'])->on('participante')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idcertificacn'], 'fk_idtipceti')->references(['idcertificacn'])->on('certificacion')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificado', function (Blueprint $table) {
            $table->dropForeign('fk_idiestcert');
            $table->dropForeign('fk_idpart');
            $table->dropForeign('fk_idtipceti');
        });
    }
};
