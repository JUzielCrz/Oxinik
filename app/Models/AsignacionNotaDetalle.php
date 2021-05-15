<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionNotaDetalle extends Model
{
    protected $table = 'detalle_nota_asignacion';
    public $timestamps =  true;
    protected $fillable = ['id','nota_asignacion_id', 'cilindros', 'tipo_gas', 'tipo_tanque', 'material', 'unidad_medida'];

    public $incrementing = true;
}