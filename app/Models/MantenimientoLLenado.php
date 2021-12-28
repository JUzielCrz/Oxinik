<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MantenimientoLLenado extends Model
{
    protected $table = 'mantenimiento_llenado';
    public $timestamps =  true;
    protected $fillable = ['id','fecha','cantidad', 'folio_talon','incidencia'];
    public $incrementing = true;
}

