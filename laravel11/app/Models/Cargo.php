<?php

namespace App\Models;
use App\Models\Tipocertificado;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';
    protected $primaryKey = 'idcargo';
    public $timestamps = false;

    protected $fillable = [
        'cargo'
    ];

    // Relación: Un cargo tiene muchos tipos de certificados
    public function tiposCertificado()
    {
        return $this->hasMany(Tipocertificado::class, 'idcargo', 'idcargo');
    }
}