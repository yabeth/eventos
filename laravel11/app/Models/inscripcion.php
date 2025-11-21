<?php

namespace App\Models;
use App\Models\persona;
use App\Models\escuela;
use App\Models\evento;
use App\Models\asistencia;
use App\Models\subevent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $table = 'inscripcion';
    protected $primaryKey = 'idincrip';
    public $timestamps = false;

    protected $fillable = [
        'idescuela',
        'idpersona',
        'idsubevento',
        'fecinscripcion'
    ];

    public function persona()
    {
        return $this->belongsTo(persona::class, 'idpersona', 'idpersona');
    }

 public function escuela()
    {
        return $this->belongsTo(escuela::class, 'idescuela', 'idescuela');
    }

    public function subevento()
    {
        return $this->belongsTo(subevent::class, 'idsubevent', 'idsubevent');
    }

    public function asistencias()
    {
        return $this->hasMany(asistencia::class, 'idincrip', 'idincrip');
    }
}