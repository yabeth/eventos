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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIinscrip`(id int)
BEGIN
  IF (SELECT COUNT(*) FROM inscripción WHERE idincrip=id)>0 THEN
  DELETE FROM inscripción where idincrip=id;
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
        DB::unprepared("DROP PROCEDURE IF EXISTS ELIinscrip");
    }
};
