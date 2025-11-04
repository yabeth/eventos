<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tiporesolucion extends Model
{
    use HasFactory;
    protected $table = 'tiporesolucion'; 
    protected $primaryKey = 'idTipresol'; 
    protected $fillable= ['nomtiprs']; 
    public $timestamps = false; 
}
