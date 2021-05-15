<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignacion';
    public $timestamps =  true;
    protected $fillable = ['id','contratos_id', 'cilindros', 'tipo_gas', 'tipo_tanque', 'material', 'precio_unitario', 'unidad_medida'];
    public $incrementing = true;
}
 