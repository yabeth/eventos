<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;

class EstadoEvento extends Model
{
    protected $table = 'estadoevento';
    protected $primaryKey = 'idestadoeve'; 
    protected $fillable = ['nomestado'];
    public $timestamps = false; 
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'idestadoeve');
    }
  
}
