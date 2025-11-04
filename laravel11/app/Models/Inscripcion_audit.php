<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion_Audit extends Model {
    protected $table = 'inscripcion_audit';
    protected $primaryKey = 'audit_id';
    protected $fillable = [
        'operation',
        'idincrip',
        'idescuela',
        'idpersona',
        'idevento',
        'fecinscripcion',
        'modified_at',
        'nomusu',
        'usuario'
    ];
}