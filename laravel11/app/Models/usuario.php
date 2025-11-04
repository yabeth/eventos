<?php


namespace App\Models;
use App\Models\tipousuario;
use App\Models\permiso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class usuario extends Authenticatable
{
   
    protected $table = 'usuario'; 
    protected $primaryKey = 'idusuario'; 
    protected $fillable= ['nomusu','pasword','idTipUsua','dniu','ubigeo','fechaemision']; 
    public $timestamps = false; 


    public function tipousuario()
    {
        return $this->belongsTo(tipousuario::class, 'idTipUsua'); 
    }
    public function datosperusu()
    {
        return $this->hasOne(datosperusu::class, 'idusuario'); // Ajusta 'id_usuario' según el nombre de la clave foránea.
    }
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'usuario_permisos');
    }

    // Verificar si el usuario tiene un permiso específico
    public function tienePermiso($ruta)
    {
        return $this->permisos->contains('nombre_ruta', $ruta);
    }
}
