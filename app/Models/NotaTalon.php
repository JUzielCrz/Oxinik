<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaTalon extends Model
{
    protected $table = 'nota_talon';
    public $timestamps =  true;
    protected $fillable = ['id',
                        'cliente_id',
                        'precio_envio',
                        'subtotal',
                        'iva_general',
                        'total',
                        'metodo_pago',
                        'fecha',
                        'user_id'
                        ];
    public $incrementing = true;
}
