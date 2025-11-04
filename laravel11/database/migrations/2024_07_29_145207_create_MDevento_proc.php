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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `MDevento`(id int,evenom varchar(60),fcini date,
descrip varchar(60), horin time, horc time,idsestadeve int, idtipev int)
BEGIN
  IF (SELECT COUNT(*) FROM evento WHERE eventnom=evenom and fecha=fcini AND
  horain=horin AND horcul=horc AND idTipoeven=idtipev and idevento<>id)=0 THEN
  UPDATE evento set eventnom=evenom, fecha=fcini, horain=horin, 
  horcul=horc, idTipoeven=idtipev, idestadoeve=idsestadeve,
  descripción=descrip
  WHERE idevento=id;   
  SELECT 'El evento se modifico correctamente';
  ELSE
  SELECT 'El evento puede generar duplicidad';
  END IF;
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS MDevento");
    }
};
