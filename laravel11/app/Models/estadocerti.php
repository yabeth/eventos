<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estadocerti extends Model
{
    use HasFactory;
    protected $table = 'estadocerti';
    protected $primaryKey = 'idestcer';
    protected $fillable=[
        'nomestadc'
    ];
    public $timestamps = false;
}