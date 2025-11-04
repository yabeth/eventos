<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class informe_auditoria extends Model {
    protected $table = 'informe_auditoria';
    protected $primaryKey = 'id_audit';
    protected $fillable = [
        'operacion',
        'usuario',
        'fecha_operacion',
        'fecha_presentacion',
        'rta',
        'idevento',
        'nombreusuario',
        'idoriginal'
    ];
}