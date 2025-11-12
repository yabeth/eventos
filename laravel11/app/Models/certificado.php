<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\certificacion;
use App\Models\asistencia;
use App\Models\estadocerti;
use App\Models\Tipocertificado;
use App\Models\Certiasiste;


class certificado extends Model
{
    protected $table = 'certificado';
    protected $primaryKey = 'idCertif';
    public $timestamps = false;

    protected $fillable = [
        'nro',
        'idestcer',
        'fecentrega',
        'idcertificacn',
        'idtipcerti',
        'cuader',
        'foli',
        'numregis',
        'tokenn',
        'descr',
        'pdff'
    ];

    public function estadoCertificado()
    {
        return $this->belongsTo(estadocerti::class, 'idestcer', 'idestcer');
    }

    public function certificacion()
    {
        return $this->belongsTo(certificacion::class, 'idcertificacn', 'idcertificacn');
    }

    public function tipoCertificado()
    {
        return $this->belongsTo(Tipocertificado::class, 'idtipcerti', 'idtipcert');
    }

    public function certiasiste()
    {
        return $this->hasOne(Certiasiste::class, 'idCertif', 'idCertif');
    }
}