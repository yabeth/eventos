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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `MODescuel`(id int,nomes varchar(45),idfa int)
BEGIN
     IF (SELECT COUNT(*) FROM escuela WHERE nomescu=nomes and idfacultad=idfa and         idescuela<>id)=0 THEN
     UPDATE escuela set nomescu=nomes,idfacultad=idfa
     WHERE idescuela=id;   
     SELECT 'La escuela se modifico correctamente';
     ELSE
     SELECT 'La escuela puede generar duplicidad';
     END IF;
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS MODescuel");
    }
};
