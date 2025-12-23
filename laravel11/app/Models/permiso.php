<?php

namespace App\Models;
use App\Models\usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';

    protected $fillable = [
        'nombre_ruta',
        'nombre_permiso'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_permiso', 'permiso_id', 'usuario_idusuario');
    }
}
