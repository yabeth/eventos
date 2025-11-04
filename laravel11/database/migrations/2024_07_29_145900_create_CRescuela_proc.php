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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `CRescuela`(nomes varchar(45),idfac int)
BEGIN
     IF(SELECT COUNT(*) FROM escuela WHERE nomescu=nomes and idfacultad=idfac)=0 THEN
     INSERT INTO escuela(nomescu,idfacultad) VALUES (nomes,idfac);
     SELECT 'La escuela se ingreso correctamente';
     ELSE
     SELECT 'La escuela ya existe';
     END IF;
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CRescuela");
    }
};
