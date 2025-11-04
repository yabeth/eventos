<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado_Auditoria extends Model
{
    

    protected $table = 'certificado_auditoria'; 
    protected $primaryKey = 'id_audit'; 
    protected $fillable= ['idoriginal','operacion','usuario', 'fecha_operacion',
    'descripcion','nombreusuario'  ]; 
    
}

