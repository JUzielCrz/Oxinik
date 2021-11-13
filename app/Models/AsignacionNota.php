<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionNota extends Model
{
    protected $table = 'nota_asignacion';
    public $timestamps =  true;
    protected $fillable = ['id','contratos_id', 'fecha','incidencia', 'deposito_garantia'];
    public $incrementing = true;
}
