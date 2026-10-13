<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfraLLenado extends Model
{
    protected $table = 'infra_llenado';
    public $timestamps =  true;
    protected $fillable = [
        'id',
        'cantidad_salida',
        'cantidad_entrada',
        'cantidad_diferencia',
        'pendiente',
        'observaciones',
        'user_id',
    ];
    public $incrementing = true;
}

