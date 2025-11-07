<?php

namespace App\Models;
use App\Models\modalidad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class canal extends Model
{
    protected $table = 'canal'; 
    protected $primaryKey = 'idcanal'; 
    protected $fillable= ['canal','url','idmodal']; 
    public $timestamps = false; 
    public function modalidad()
    {
    return $this->belongsTo(modalidad::class, 'idmodal'); 
    }

}
