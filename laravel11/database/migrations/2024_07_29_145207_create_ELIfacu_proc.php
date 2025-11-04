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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIfacu`(id int)
BEGIN
      IF (SELECT COUNT(*) FROM facultad WHERE idfacultad=id)>0 THEN
      DELETE FROM facultad where idfacultad=id;
      SELECT 'La facultad se eliminó correctamente';
     ELSE
     SELECT 'La facultad no se puede eliminar';
     END IF; 
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ELIfacu");
    }
};
