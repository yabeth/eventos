<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoEvento;
use App\Models\tipoevento;
use App\Models\Resoluciaprob;
class Evento extends Model
{
    
    protected $table = 'evento'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idevento'; 
    protected $fillable= ['eventnom','idTipoeven','idestadoeve','descripción','fecini','horain','horcul']; 
    public $timestamps = false; // Si no usas timestamps
    public function estadoEvento()
    {
        return $this->belongsTo(EstadoEvento::class, 'idestadoeve'); 
    }

    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class, 'idTipoeven');
    }
    public function Resoluciaprob()
    {
        return $this->hasOne(Resoluciaprob::class, 'idevento', 'idevento'); 
    }
}

