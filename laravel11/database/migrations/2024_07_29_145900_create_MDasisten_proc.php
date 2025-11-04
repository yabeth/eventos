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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `MDasisten`(id int,
    fecha date, idper int,ideven int, idtipoasis int
)
BEGIN
   DECLARE idinsc INT;
    SELECT idincrip INTO  idinsc
    FROM  inscripción
    WHERE  idevento= ideven and idpersona=idper;
    
  IF (SELECT COUNT(*) FROM asistencia WHERE idincrip=idinsc and idasistnc<>id)=0 THEN
  UPDATE asistencia set fech=fecha, idtipasis=idtipoasis
  WHERE idasistnc=id;   
  SELECT 'La asistencia se modifico correctamente';
  ELSE
  SELECT 'Puede generar duplicidad';
  END IF;
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS MDasisten");
    }
};
