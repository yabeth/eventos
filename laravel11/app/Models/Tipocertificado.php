<?php

namespace App\Models;
use App\Models\Cargo;

use Illuminate\Database\Eloquent\Model;

class Tipocertificado extends Model
{
    protected $table = 'tipocertificado';
    protected $primaryKey = 'idtipcert';
    public $timestamps = false;

    protected $fillable = ['tipocertifi', 'idcargo'];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'idcargo', 'idcargo');
    }
}