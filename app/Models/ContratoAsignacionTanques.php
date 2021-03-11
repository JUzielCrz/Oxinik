<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoAsignacionTanques extends Model
{
    protected $table = 'asignaciontanques_contrato';
    public $timestamps =  true;
    protected $fillable = ['id','num_contrato','fecha', 'cantidad','incidencia'];
    public $incrementing = true;
}
