<?php

namespace App\Models;
use App\Models\tipoasiste;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asistencia extends Model {
    protected $table = 'asistencia';
    protected $primaryKey = 'idasistnc';
    public $timestamps = false;

    protected $fillable = [
        'fech', 'idtipasis', 'idincrip', 'idestado', 'porceasis'
    ];

    public function tipoasiste()
    {
        return $this->belongsTo(tipoasiste::class, 'idtipasis', 'idtipasis');
    }

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'idincrip', 'idincrip');
    }

    public function certiasiste()
    {
        return $this->hasOne(Certiasiste::class, 'idasistnc', 'idasistnc');
    }
}