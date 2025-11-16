<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;
use App\Models\Estadocerti;
use App\Models\Tipocertificado;
use App\Models\Certiasiste;
use App\Models\Certinormal;
use App\Models\asistencia;

class Certificado extends Model
{
    protected $table = 'certificado';
    protected $primaryKey = 'idCertif';
    public $timestamps = false;

    protected $fillable = [
        'nro',
        'idestcer',
        'fecentrega',
        'idtipcerti',
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
        return $this->belongsTo(Estadocerti::class, 'idestcer', 'idestcer');
    }

    public function tipoCertificado()
    {
        return $this->belongsTo(Tipocertificado::class, 'idtipcerti', 'idtipcert');
    }

    public function certiasiste()
    {
        return $this->hasOne(Certiasiste::class, 'idCertif', 'idCertif');
    }

    public function certinormal()
    {
        return $this->hasOne(Certinormal::class, 'idCertif', 'idCertif');
    }

    public function asistencia()
    {
        return $this->belongsTo(asistencia::class, 'idasistnc', 'idasistnc');
    }
}
