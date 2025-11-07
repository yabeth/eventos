<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipresolucionAgrad extends Model
{
    use HasFactory;

    protected $table = 'tipresolucagrd';
    protected $primaryKey = 'idtipagr';

    protected $fillable = ['tipoagradeci'];

    public $timestamps = false;
}
