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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ELIescue`(id int)
BEGIN
      IF (SELECT COUNT(*) FROM escuela WHERE idescuela=id)>0 THEN
      DELETE FROM escuela where idescuela=id;
      SELECT 'La escuela se eliminó correctamente';
     ELSE
     SELECT 'La escuela no se puede eliminar';
     END IF; 
     END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ELIescue");
    }
};
