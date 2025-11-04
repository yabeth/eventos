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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `CRinscrip`(
    IN dn VARCHAR(10),
    IN ape VARCHAR(60),
    IN dire VARCHAR(60),
    IN emal VARCHAR(45),
    IN idgener INT,
    IN nom VARCHAR(50),
    IN celu VARCHAR(10),
    IN idescu INT,
    IN ideven INT
)
BEGIN
    DECLARE pid INT;

    -- Buscar si la persona ya existe
    SELECT idpersona INTO pid
    FROM personas
    WHERE dni = dn;

    -- Si la persona no existe, insertarla y obtener su ID
    IF pid IS NULL THEN
        INSERT INTO personas (apell, direc, dni, email, idgenero, nombre, tele)
        VALUES (ape, dire, dn, emal, idgener, nom, celu);
        SET pid = LAST_INSERT_ID();
    END IF;

    -- Verificar si la inscripción ya existe
    IF (SELECT COUNT(*) FROM inscripción WHERE idpersona = pid AND idescuela = idescu AND idevento = ideven) = 0 THEN
        INSERT INTO inscripción (idescuela, idevento, idpersona)
        VALUES (idescu, ideven, pid);
        SELECT 'Se registró correctamente' AS mensaje;
    ELSE
        SELECT 'No se puede registrar dos veces' AS mensaje;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CRinscrip");
    }
};
