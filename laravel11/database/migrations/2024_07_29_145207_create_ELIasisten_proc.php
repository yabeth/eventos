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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIasisten`(id int)
BEGIN
  IF (SELECT COUNT(*) FROM asistencia WHERE idasistnc=id)>0 THEN
  DELETE FROM asistencia where idasistnc=id;
  SELECT 'Se liminó correctamente';
  ELSE
  SELECT 'No se puede eliminar';
  END IF; 
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ELIasisten");
    }
};
