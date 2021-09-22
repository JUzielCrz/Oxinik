<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaTanque extends Model
{
    protected $table = 'venta_tanque';
    public $timestamps =  true;
    protected $fillable = ['id', 'venta_id','num_serie','cantidad', 'unidad_medida', 'precio_unitario', 'tapa_tanque', 'iva_particular','importe','insidencia'];
    public $incrementing = true;
}