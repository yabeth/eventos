<?php

namespace App\Models;
use App\Models\genero;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class persona extends Model
{
    protected $table = 'personas'; 
    protected $primaryKey = 'idpersona'; 
    protected $fillable= ['dni','nombre','apell','tele','email','direc','idgenero']; 
    public $timestamps = false; 
    public function genero()
    {
    return $this->belongsTo(genero::class, 'idgenero'); 
    }
    public function inscripcion()
    {
        return $this->hasMany(Inscripcion::class, 'idpersona');
    }

}
