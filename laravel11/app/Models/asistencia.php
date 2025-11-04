<?php

namespace App\Models;
use App\Models\tipoasiste;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    protected $table = 'asistencia'; 
    protected $primaryKey = 'idasistnc'; 
    protected $fillable= ['fech','idtipasis','idincrip']; 
    public $timestamps = false; 
   
    public function tipoasiste()
    {
        return $this->belongsTo(tipoasiste::class, 'idtipasis'); 
    }
    public function inscripcion()
    {
        return $this->belongsTo(inscripcion::class, 'idincrip'); 
    }
   
}
