<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaExporadica extends Model
{
    protected $table = 'ventas';
    public $timestamps =  true;
    protected $fillable = ['id',
                        'nombre_cliente',
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
                        'fecha'
                        ];
    public $incrementing = true;
}