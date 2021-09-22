<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaTanque extends Model
{
    protected $table = 'nota_tanque';
    public $timestamps =  true;
    protected $fillable = ['nota_id','num_serie', 'cantidad', 'unidad_medida', 'precio_unitario', 'tapa_tanque','iva_particular', 'importe', 'devuelto'];
}
