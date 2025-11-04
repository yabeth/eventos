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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `MODtipeven`( id int,nomtie varchar(45))
BEGIN
  IF (SELECT COUNT(*) FROM tipoevento WHERE nomeven=nomtie and idTipoeven<>id)=0 THEN
  UPDATE tipoevento set nomeven=nomtie
  WHERE idTipoeven=id;   
  SELECT 'El tipo de evento se modifico correctamente';
  ELSE
  SELECT 'El tipo de evento puede generar duplicidad';
  END IF;
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS MODtipeven");
    }
};
