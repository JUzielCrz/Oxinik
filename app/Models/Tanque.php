<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    protected $table = 'tanques';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie','ph', 'capacidad','material', 'fabricante', 'tipo_gas', 'tipo_tanque','estatus'];
    public $incrementing = true;


}
