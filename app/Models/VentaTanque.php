<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaTanque extends Model
{
    protected $table = 'venta_tanque';
    public $timestamps =  true;
    protected $fillable = ['id', 'venta_id','num_serie', 'precio', 'regulador', 'tapa_tanque', 'insidencia'];
    public $incrementing = true;
}