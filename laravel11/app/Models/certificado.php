<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\certificacion;
use App\Models\asistencia;
use App\Models\estadocerti;


class certificado extends Model
{
    protected $table = 'certificado'; 
    protected $primaryKey = 'idCertif'; 
    protected $fillable= ['nro','idcertificacn','idestcer','idasistnc','idcertificacn']; 
    public $timestamps = false;

    public function certificacion()
    {
        return $this->belongsTo(certificacion::class, 'idcertificacn'); 
    }

    public function asistencia()
    {
        return $this->belongsTo(asistencia::class, 'idasistnc'); 
    }

    public function estadocerti()
    {
        return $this->belongsTo(estadocerti::class, 'idestcer'); 
    }
    
}
