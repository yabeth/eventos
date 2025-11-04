<?php

namespace App\Models;
use App\Models\evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class certificacion extends Model
{
    protected $table = 'certificacion'; 
    protected $primaryKey = 'idcertificacn'; 
    protected $fillable= ['fechora','obser','idevento']; 
    public $timestamps = false;
    
    public function evento()
    {
        return $this->belongsTo(evento::class, 'idevento'); 
    }
 
}
