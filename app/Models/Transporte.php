<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    protected $table = 'transportes';
    protected $fillable = ['id','fecha', 'car_id', 'driver_id'];
}
