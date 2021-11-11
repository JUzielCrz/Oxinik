<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaForaneaTanque extends Model
{
    protected $table = 'notaforanea_tanque';
    public $timestamps =  true;
    protected $fillable = ['id', 'nota_foranea_id','num_serie','cantidad', 'unidad_medida', 'precio_unitario', 'tapa_tanque', 'iva_particular','importe','insidencia'];
    public $incrementing = true;
}
