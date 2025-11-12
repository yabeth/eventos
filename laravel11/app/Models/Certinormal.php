<?php

namespace App\Models;
use App\Models\persona;
use App\Models\certificado;

use Illuminate\Database\Eloquent\Model;

class Certinormal extends Model
{
    protected $table = 'certinormal';
    protected $primaryKey = 'idcertinorm';
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(persona::class, 'idpersona', 'idpersona');
    }
    public function certificado()
    {
        return $this->belongsTo(certificado::class, 'idCertif', 'idCertif');
    }
}
