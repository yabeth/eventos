<?php

namespace App\Models;
use App\Models\Evento;
use App\Models\Canal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subevent extends Model
{
     protected $table = 'subevent'; 
    protected $primaryKey = 'idsubevent ';
    protected $fillable = ['fechsubeve', 'horini', 'horfin', 'Descripcion', 'idevento', 'idcanal'];
    public $timestamps = false; 
    public function Evento()
    {
        return $this->belongsTo(Evento::class, 'idevento');
    }

    public function Canal()
    {
        return $this->belongsTo(Canal::class, 'idcanal');
    }
}
