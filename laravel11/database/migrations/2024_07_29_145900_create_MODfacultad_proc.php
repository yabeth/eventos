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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `MODfacultad`( id int,nomfa varchar(45))
BEGIN
     IF (SELECT COUNT(*) FROM facultad WHERE nomfac=nomfa and idfacultad<>id)=0 THEN
     UPDATE facultad set nomfac=nomfa
     WHERE idfacultad=id;   
     SELECT 'La facultad se modifico correctamente';
     ELSE
     SELECT 'La facultad puede generar duplicidad';
     END IF;
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS MODfacultad");
    }
};
