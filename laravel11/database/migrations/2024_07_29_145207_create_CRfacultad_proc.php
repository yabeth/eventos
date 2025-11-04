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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `CRfacultad`( nomfa varchar(45))
BEGIN
     IF(SELECT COUNT(*) FROM facultad WHERE nomfac=nomfa)=0 THEN
     INSERT INTO facultad(nomfac) VALUES (nomfa);
     SELECT 'La facultad se ingreso correctamente';
     ELSE
     SELECT 'La facultad ya existe';
     END IF;
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CRfacultad");
    }
};
