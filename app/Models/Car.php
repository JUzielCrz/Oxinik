<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $timestamps =  true;
    protected $fillable = ['nombre',  'modelo', 'marca', 'placa'];
    public $incrementing = true;
}
