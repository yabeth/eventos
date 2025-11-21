<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tipocertificado;

class Cargo extends Model
{
    protected $table = 'cargo';
    protected $primaryKey = 'idcargo';
    public $timestamps = false;

    protected $fillable = [
        'cargo',
        'idtipcert'
    ];

    public function tipoCertificado()
    {
        return $this->belongsTo(Tipocertificado::class, 'idtipcert', 'idtipcert');
    }

    public function certificado()
    {
        return $this->hasMany(Certificado::class, 'idcargo', 'idcargo');
    }

}
