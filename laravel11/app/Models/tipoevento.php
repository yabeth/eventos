<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class TipoEvento extends Model
{
    protected $table = 'tipoevento'; 
    protected $primaryKey = 'idTipoeven'; 
    protected $fillable = ['nomeven'];
    public $timestamps = false; 

    
}
