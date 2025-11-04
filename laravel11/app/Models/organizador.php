<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organizador extends Model
{
    protected $table = 'organizador'; 
    protected $primaryKey = 'idorg'; 
    protected $fillable= ['nombreor','idtipo']; 
    public $timestamps = false; 


    public function tipoorg()
    {
        return $this->belongsTo(tipoorg::class, 'idtipo'); 
    }

}
