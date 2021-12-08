<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaForanea extends Model
{
    protected $table = 'nota_foranea';
    public $timestamps =  true;
    protected $fillable = [
                        'id',
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
