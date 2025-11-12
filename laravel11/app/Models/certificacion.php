<?php

namespace App\Models;
use App\Models\evento;
use App\Models\certificado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class certificacion extends Model {
    protected $table = 'certificacion';
    protected $primaryKey = 'idcertificacn';
    public $timestamps = false;

    protected $fillable = ['obser', 'idevento', 'Tiempocapa'];

    public function evento()
    {
        return $this->belongsTo(evento::class, 'idevento', 'idevento');
    }

    public function certificados()
    {
        return $this->hasMany(certificado::class, 'idcertificacn', 'idcertificacn');
    }
}
