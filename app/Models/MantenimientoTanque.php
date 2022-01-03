<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantenimientoTanque extends Model
{
    protected $table = 'mantenimiento_tanques';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie','mantenimientollenado_id','folio_talon','incidencia'];
    public $incrementing = true;
}

