<?php


namespace App\Models;
use App\Models\tipousuario;
use App\Models\permiso;
use App\Models\persona;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class usuario extends Authenticatable
{
   
    protected $table = 'usuario'; 
    protected $primaryKey = 'idusuario'; 
    protected $fillable= ['nomusu','pasword','idTipUsua','ubigeo','fechaemision','idpersona']; 
    public $timestamps = false; 


    public function tipousuario()
    {
        return $this->belongsTo(tipousuario::class, 'idTipUsua'); 
    }
   public function persona()
{
    return $this->belongsTo(persona::class, 'idpersona');
}

 
    public function permisos()
{
    return $this->belongsToMany(
        Permiso::class,          // Modelo relacionado
        'usuario_permisos',      // Tabla pivote
        'usuario_idusuario',     // FK hacia usuario
        'permiso_id'             // FK hacia permiso
    );
}


    public function tienePermiso($ruta)
    {
        return $this->permisos->contains('nombre_ruta', $ruta);
    }
}
