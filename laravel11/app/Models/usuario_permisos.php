<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\usuario;
use App\Models\permiso;


class usuario_permisos extends Model
{
    protected $table = 'usuario_permisos'; 
    protected $primaryKey = 'idusuariopermiso'; 
    protected $fillable= ['usuario_idusuario','permiso_id']; 
    public $timestamps = false; 

    public function usuario()
    {
        return $this->belongsTo(usuario::class, 'usuario_idusuario'); 
    }
    public function permiso()
    {
        return $this->belongsTo(permiso::class, 'permiso_id'); 
    }
}
