<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facultad extends Model
{
    use HasFactory;
    protected $table = 'facultad';
    protected $primaryKey = 'idfacultad';
    protected $fillable=[
        'nomfac'
    ];
    public $timestamps = false;
}


