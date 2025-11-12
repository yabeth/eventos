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

    protected $fillable = ['fech', 'idtipasis', 'idincrip', 'idestado'];

    public function inscripcion()
    {
        return $this->belongsTo(inscripcion::class, 'idincrip', 'idincrip');
    }

    public function tipoAsistencia()
    {
        return $this->belongsTo(tipoasiste::class, 'idtipasis', 'idtipasis');
    }
}
