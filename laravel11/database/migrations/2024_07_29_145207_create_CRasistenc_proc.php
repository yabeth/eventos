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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `CRasistenc`(
    fecha date, idper int,ideven int, idtipoasis int
)
BEGIN
    DECLARE idinsc INT;

    SELECT idincrip INTO  idinsc
    FROM  inscripción
    WHERE  idevento= ideven and idpersona=idper;

      IF(SELECT COUNT(*) FROM asistencia WHERE idincrip=idinsc)=0 THEN
      INSERT INTO asistencia(fech,idincrip,idtipasis)
      VALUES (fecha ,idinsc,idtipoasis);
     SELECT 'La asistencia se registró correctamente';
     ELSE
     SELECT 'No se puede registrar la asistencia';
     END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CRasistenc");
    }
};
