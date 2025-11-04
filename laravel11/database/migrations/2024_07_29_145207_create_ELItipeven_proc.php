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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ELItipeven`(id int)
BEGIN
  IF (SELECT COUNT(*) FROM tipoevento WHERE idTipoeven=id)>0 THEN
  DELETE FROM tipoevento where idTipoeven=id;
  SELECT 'El tipo de evento se eliminó correctamente';
  ELSE
  SELECT 'El tipo de evento no se puede eliminar';
  END IF; 
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ELItipeven");
    }
};
