<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento_Auditoria extends Model
{
    

    protected $table = 'evento_auditoria'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_audit'; 
    protected $fillable= ['ideventooriginal','operacion','usuario', 'fecha_operacion',
    'descripcioneven','nombreusuario'  ]; 
    //public $timestamps = false; // Si no usas timestamps
    
}

