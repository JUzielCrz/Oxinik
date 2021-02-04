<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanqueHistorial extends Model
{
    
    protected $table = 'tanque_historial';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie','ph', 'capacidad','material', 'fabricante', 'tipo_gas'];
    public $incrementing = true;

}
