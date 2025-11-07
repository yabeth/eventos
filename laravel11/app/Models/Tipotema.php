<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipotema extends Model
{
    use HasFactory;

    protected $table = 'tema';
    protected $primaryKey = 'idtema';

    protected $fillable = ['tema'];

    public $timestamps = false;
}