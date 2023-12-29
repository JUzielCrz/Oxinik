<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';
    protected $fillable = ['id','nombre', 'apellido', 'licencia_tipo','licencia_numero'];
    public $incrementing = true;
}
