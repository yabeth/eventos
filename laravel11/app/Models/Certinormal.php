<?php

namespace App\Models;

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
}
