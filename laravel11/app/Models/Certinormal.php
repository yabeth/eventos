<?php

namespace App\Models;
use App\Models\Persona;
use App\Models\Certiasiste;

use Illuminate\Database\Eloquent\Model;

class Certinormal extends Model
{
    protected $table = 'certinormal';
    protected $primaryKey = 'idcertinorm';
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idpersona', 'idpersona');
    }

    public function certiasiste()
{
    return $this->hasOne(Certiasiste::class, 'idCertif', 'idCertif');
}

public function certinormal()
{
    return $this->hasOne(Certinormal::class, 'idCertif', 'idCertif');
}
}
