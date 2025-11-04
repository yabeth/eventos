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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `MDincripcion`(idinscr int,
dn VARCHAR(10),ape VARCHAR(60),dire VARCHAR(60),
emal VARCHAR(45),idgener INT,nom VARCHAR(50),
celu VARCHAR(10), idescu INT, ideven INT)
BEGIN
    DECLARE pid INT;
    SELECT idpersona INTO pid
    FROM inscripción
    WHERE idincrip=idinscr;
    
  IF (SELECT COUNT(*) FROM personas WHERE dni=dn and idpersona<>pid)=0 THEN
  UPDATE personas set dni=dn, apell=ape, direc=dire, 
  email=emal, idgenero=idgener, nombre=nom,tele=celu
  WHERE idpersona=pid;  
  END IF;
  
  IF (SELECT COUNT(*) FROM inscripción WHERE idevento=ideven and idpersona=pid AND
   idescuela=idescu  and idincrip<>idinscr)=0 THEN
  UPDATE inscripción set idescuela=idescu,idevento=ideven, idpersona=pid
  WHERE idincrip=idinscr;  
  
  SELECT 'Se modifico los datos correctamente';
  ELSE
  SELECT 'Los nuevos datos puede generar duplicidad';
  END IF;
  END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS MDincripcion");
    }
};
