<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    public $timestamps =  true;
    protected $fillable = ['id','cliente','direccion', 'telefono','rfc', 'cfdi', 'direccion_factura', 'metodo_pago'];
    public $incrementing = true;
}