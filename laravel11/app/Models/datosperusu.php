<?php
namespace App\Models;
use App\Models\usuario;
use App\Models\persona;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datosperusu extends Model
{
    protected $table = 'datosperusu'; 
    protected $primaryKey = 'idatosPer'; 
    protected $fillable= ['idpersona','idusuario']; 
    public $timestamps = false; 

    public function usuario()
    {
        return $this->belongsTo(usuario::class, 'idusuario'); 
    }

    public function persona()
    {
        return $this->belongsTo(persona::class, 'idpersona'); 
    }
    
}
