<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipousuario extends Model
{
    use HasFactory;
    protected $table = 'tipousuario';
    protected $primaryKey = 'idTipUsua';
    protected $fillable=['tipousu'
    ];
    public $timestamps = false;
}
