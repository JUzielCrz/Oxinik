<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contratos';
    public $timestamps =  true;
    protected $fillable = ['id','num_contrato','cliente_id', 'tipo_contrato','precio_definido','precio_transporte', 'reguladores', 'observaciones'];
    public $incrementing = true;
}
