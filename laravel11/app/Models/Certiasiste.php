<?php

namespace App\Models;
use App\Models\certificado;
use App\Models\asistencia;

use Illuminate\Database\Eloquent\Model;

class Certiasiste extends Model
{
    protected $table = 'certiasiste';
    protected $primaryKey = 'idcertiasist';
    public $timestamps = false;

    protected $fillable = ['idasistnc', 'idCertif', 'porceasis'];

    public function certificado()
    {
        return $this->belongsTo(certificado::class, 'idCertif', 'idCertif');
    }

    public function asistencia()
    {
        return $this->belongsTo(asistencia::class, 'idasistnc', 'idasistnc');
    }
}