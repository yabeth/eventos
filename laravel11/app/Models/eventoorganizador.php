<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventoorganizador extends Model
{
    protected $table = 'eventoorganizador';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['idevento', 'idorg'];

    public function evento()
    {
        return $this->belongsTo(evento::class, 'idevento'); 
    }
    public function organizador()
    {
        return $this->belongsTo(organizador::class, 'idorg'); 
    }

}
