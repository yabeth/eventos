<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\evento;
use App\Models\tipoinforme;
class informe extends Model
{
    protected $table = 'informe'; 
    protected $primaryKey = 'idinforme'; 
    protected $fillable= ['fecpres','idTipinfor','rta','idevento']; 
    public $timestamps = false; 

    public function evento()
    {
        return $this->belongsTo(evento::class, 'idevento');
    }

    public function tipoinforme()
    {
        return $this->belongsTo(tipoinforme::class, 'idTipinfor');
    }
}
