<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaPagos extends Model
{

    protected $table = 'nota_pagos';
    public $timestamps =  true;
    protected $fillable = ['nota_id','monto_pago', 'metodo_pago'];

}
