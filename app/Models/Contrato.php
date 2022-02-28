<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contratos';
    public $timestamps =  true;
    protected $fillable = ['id','cliente_id', 'tipo_contrato', 'nombre_comercial','reguladores','modelo_regulador','precio_transporte','direccion', 'referencia','calle1','calle2', 'link_ubicacion','observaciones'];
    public $incrementing = true;
}
