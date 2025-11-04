<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia_Audit extends Model {
    protected $table = 'asistencia_audit';
    protected $primaryKey = 'audit_id';
    protected $fillable = [ 'operation', 'idasistnc',
        'fech', 'idtipasis', 'idincrip', 'idestado', 'modified_at',
        'nomusu', 'usuario'
    ];
}