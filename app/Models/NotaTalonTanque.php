<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaTalonTanque extends Model
{
    protected $table = 'nota_talontanque';
    public $timestamps =  true;
    protected $fillable = ['id', 'nota_talon_id','num_serie','cantidad', 'unidad_medida', 'precio_unitario', 'tapa_tanque', 'iva_particular','importe','insidencia'];
    public $incrementing = true;
}
