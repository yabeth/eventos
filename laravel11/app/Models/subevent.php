<?php

namespace App\Models;
use App\Models\Evento;
use App\Models\Canal;
use App\Models\asignarponent;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subevent extends Model
{
     protected $table = 'subevent'; 
    protected $primaryKey = 'idsubevent';
    protected $fillable = ['fechsubeve', 'horini', 'horfin', 'Descripcion', 'idevento', 'idcanal', 'url'];
    public $timestamps = false; 
    
    public function Evento()
    {
        return $this->belongsTo(evento::class, 'idevento', 'idevento');
    }

    public function canal()
    {
        return $this->belongsTo(Canal::class, 'idcanal');
    }
    public function asignarponentes()
   {
        return $this->hasMany(Asignarponent::class, 'idsubevent', 'idsubevent');
    }

    public function inscripciones()
    {
        return $this->hasMany(inscripcion::class, 'idsubevento', 'idsubevent');
    }

   
    
}
