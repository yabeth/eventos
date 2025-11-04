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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `CRevento`(evenom varchar(60),fcini date,
descrip varchar(60), horin time, horc time,idsestadeve int, idtipev int)
BEGIN 
     IF(SELECT COUNT(*) FROM evento WHERE eventnom=evenom and fecha=fcini AND
       horain=horin AND horcul=horc AND idTipoeven=idtipev)=0 THEN
      INSERT INTO       evento(descripción,eventnom,fecha,horain,horcul,idestadoeve,idTipoeven)
      VALUES (descrip,evenom,fcini,horin,horc,idsestadeve,idtipev );
      SELECT 'El evento se ingreso correctamente';
      ELSE
      SELECT 'El evento ya existe';
      END IF;
      END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CRevento");
    }
};
