<?php

namespace App\Models;
use App\Models\Certificado;
use App\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;

class Certiasiste extends Model
{
    protected $table = 'certiasiste';
    protected $primaryKey = 'idcertiasist';
    public $timestamps = false;

    protected $fillable = ['idasistnc', 'idCertif'];

    public function certificado()
    {
        return $this->belongsTo(Certificado::class, 'idCertif', 'idCertif');
    }

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'idasistnc', 'idasistnc');
    }
}