<?php

namespace App\Models;
use App\Models\Persona;
use App\Models\Certificado;

use Illuminate\Database\Eloquent\Model;

class Certinormal extends Model
{
    protected $table = 'certinormal';
    protected $primaryKey = 'idcertinorm';
    public $timestamps = false;

    protected $fillable = [
        'idCertif', 'idpersona'
    ];

    public function certificado() {
        return $this->belongsTo(Certificado::class, 'idCertif', 'idCertif');
    }

    // Relación con Persona
    public function persona() {
        return $this->belongsTo(Persona::class, 'idpersona', 'idpersona');
    }

    
}
