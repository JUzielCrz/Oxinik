<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteSinContrato extends Model
{
    protected $table = 'clientes_sin_contrato';
    public $timestamps =  true;
    protected $fillable = [
        'id',
        // 'cliente_id',
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
    ];
    public $incrementing = true;
}
