<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignacion';
    public $timestamps =  true;
    protected $fillable = ['id','contratos_id', 'cantidad', 'tipo_gas'];
    public $incrementing = true;
}
 