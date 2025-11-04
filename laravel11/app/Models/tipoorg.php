<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoorg extends Model
{
    protected $table = 'tipoorg'; 
    protected $primaryKey = 'idtipo'; 
    protected $fillable = ['nombre'];
    public $timestamps = false; 
}
