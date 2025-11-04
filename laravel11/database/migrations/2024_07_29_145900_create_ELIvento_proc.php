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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIvento`(id int)
BEGIN
  IF (SELECT COUNT(*) FROM evento WHERE idevento=id)>0 THEN
  DELETE FROM evento where idevento=id;
  SELECT 'El evento se eliminó correctamente';
  ELSE
  SELECT 'El evento no se puede eliminar';
  END IF; 
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ELIvento");
    }
};
