<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $fillable = ['dni', 'nombre', 'apell', 'email', 'tele', 'direc', 'idgenero', 'idescuela'];
}
