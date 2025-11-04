<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `CRtipeven`( nomeve varchar(45))
BEGIN
     IF(SELECT COUNT(*) FROM tipoevento WHERE nomeven=nomeve)=0 THEN
     INSERT INTO tipoevento(nomeven) VALUES (nomeve);
     SELECT 'El tipo de evento se ingreso correctamente';
     ELSE
     SELECT 'El tipo de evento ya existe';
     END IF;
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CRtipeven");
    }
};
