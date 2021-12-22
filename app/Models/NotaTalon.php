<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaTalon extends Model
{
    protected $table = 'nota_talon';
    public $timestamps =  true;
    protected $fillable = ['id',
                        'num_cliente',
                        'nombre',
                        'telefono',
                        'email',
                        'direccion',
                        'rfc',
                        'cfdi',
                        'direccion_factura',
                        'direccion_envio',
                        'referencia_envio',
                        'link_ubicacion_envio',
                        'precio_envio',
                        'subtotal',
                        'iva_general',
                        'total',
                        'metodo_pago',
                        'fecha',
                        'user_id',
                        'observaciones'
                        ];
    public $incrementing = true;
}
