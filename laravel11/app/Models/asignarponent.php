<?php

namespace App\Models;
use App\Models\persona;
use App\Models\subevent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignarponent extends Model
{
   protected $table = 'asignarponent'; 
    protected $primaryKey = 'idasig'; 
    protected $fillable= ['idpersona','idsubevent']; 
    public $timestamps = false; 
   
    public function persona()
    {
        return $this->belongsTo(persona::class, 'idpersona'); 
    }
    public function subevent()
{
    return $this->belongsTo(subevent::class, 'idsubevent', 'idsubevent');
}

}
