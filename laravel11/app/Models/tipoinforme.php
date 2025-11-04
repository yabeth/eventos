<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Tipoinforme extends Model
{
    protected $table = 'tipoinforme';
    protected $primaryKey = 'idTipinfor'; 
    protected $fillable = ['nomtinform'];
    public $timestamps = false;

    
}
