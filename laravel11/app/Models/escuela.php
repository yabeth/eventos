<?php

namespace App\Models;
use App\Models\facultad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class escuela extends Model
{
    protected $table = 'escuela'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idescuela'; 
    protected $fillable= ['nomescu','idfacultad']; 
    public $timestamps = false; // Si no usas timestamps


    public function facultad()
    {
        return $this->belongsTo(facultad::class, 'idfacultad'); 
    }

    
}
