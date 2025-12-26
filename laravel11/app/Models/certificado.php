<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;
use App\Models\estadocerti;
use App\Models\Certiasiste;
use App\Models\Certinormal;
use App\Models\asistencia;
use App\Models\Cargo;

class Certificado extends Model
{
    protected $table = 'certificado';
    protected $primaryKey = 'idCertif';
    public $timestamps = false;

    protected $fillable = [
        'nro',
        'idestcer',
        'fecentrega',
        'idcargo',
        'cuader',
        'foli',
        'numregis',
        'tokenn',
        'descr',
        'pdff',
        'tiempocapa',
        'idevento'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'idevento', 'idevento');
    }

    public function estadoCertificado()
    {
        return $this->belongsTo(estadocerti::class, 'idestcer', 'idestcer');
    }

    public function Cargo()
    {
        return $this->belongsTo(Cargo::class, 'idcargo', 'idcargo');
    }

    public function certiasiste()
    {
        return $this->hasOne(Certiasiste::class, 'idCertif', 'idCertif');
    }

    public function certinormal()
    {
        return $this->hasOne(Certinormal::class, 'idCertif', 'idCertif');
    }

    public function persona() {
        return $this->belongsToMany(Persona::class, 'certinormal', 'idCertif', 'idpersona');
    }

    public function asistencia()
    {
        return $this->belongsTo(asistencia::class, 'idasistnc', 'idasistnc');
    }
}
