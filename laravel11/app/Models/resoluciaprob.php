<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\evento;
use App\Models\tiporesolucion;
use App\Models\TipresolucionAgrad;

class resoluciaprob extends Model
{
    protected $table = 'resoluciaprob'; 
    protected $primaryKey = 'idreslaprb'; 
    protected $fillable= ['nrores','fechapro','idTipresol','idevento','ruta','fecharegist','idtipagr','numresolagradcmt']; 
    public $timestamps = false; 

    public function evento()
    {
        return $this->belongsTo(evento::class, 'idevento'); 
    }

    public function tiporesolucion()
    {
        return $this->belongsTo(tiporesolucion::class, 'idTipresol'); 
    }
     public function TipresolucionAgrad()
    {
        return $this->belongsTo(TipresolucionAgrad::class, 'idtipagr'); 
    }


}
