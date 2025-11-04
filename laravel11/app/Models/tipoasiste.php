<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoasiste extends Model
{
    protected $table = 'tipoasiste'; 
    protected $primaryKey = 'idtipasis'; 
    protected $fillable = ['nomasis'];
    public $timestamps = false; 

}
