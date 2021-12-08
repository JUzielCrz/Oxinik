<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaExporadica extends Model
{
    protected $table = 'ventas';
    public $timestamps =  true;
    protected $fillable = [
                        'id',
                        'cliente_id',
                        'precio_envio',
                        'subtotal',
                        'iva_general',
                        'total',
                        'metodo_pago',
                        'fecha'
                        ];
    public $incrementing = true;
}