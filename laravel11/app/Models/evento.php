<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoEvento;
use App\Models\tipoevento;
use App\Models\Resoluciaprob;
use App\Models\Tipotema;
use App\Models\subevent;
use App\Models\certificacion;

class Evento extends Model
{

    protected $table = 'evento';
    protected $primaryKey = 'idevento';
    public $timestamps = false;

    protected $fillable = [
        'eventnom', 'idTipoeven', 'idestadoeve', 'descripción', 'fecini', 'fechculm', 'idtema'];
     
    public function estadoEvento()
    {
        return $this->belongsTo(EstadoEvento::class, 'idestadoeve', 'idestadoeve');
    }

    public function tipoEvento()
    {
        return $this->belongsTo(tipoEvento::class, 'idTipoeven', 'idTipoeven');
    }

    public function tema()
    {
        return $this->belongsTo(Tipotema::class, 'idtema', 'idtema');
    }

    public function resoluciaprob()
    {
        return $this->hasMany(Resoluciaprob::class, 'idevento', 'idevento');
    }

    public function subeventos()
    {
        return $this->hasMany(subevent::class, 'idevento', 'idevento');
    }

    public function certificacion()
    {
        return $this->hasOne(certificacion::class, 'idevento', 'idevento');
    }

    public function informes()
    {
        return $this->hasMany(Informe::class, 'idevento', 'idevento');
    }

    public function organizadores()
    {
        return $this->belongsToMany(
            Organizador::class,
            'eventoorganizador',
            'idevento',
            'idorg'
        );
    }
}
