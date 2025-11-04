<?php

namespace App\Models;
use App\Models\persona;
use App\Models\escuela;
use App\Models\evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $table = 'inscripcion'; 
    protected $primaryKey = 'idincrip'; 
    protected $fillable= ['idescuela','idpersona','idevento']; 
    public $timestamps = false; 
   
    public function persona()
    {
        return $this->belongsTo(persona::class, 'idpersona'); 
    }
    public function evento()
    {
        return $this->belongsTo(evento::class, 'idevento'); 
    }
    public function escuela()
    {
        return $this->belongsTo(escuela::class, 'idescuela'); 
    }
   
   
}
