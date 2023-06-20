<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcentratorNota extends Model
{
    protected $table = 'concentrator_notas';
    public $timestamps =  true;
    protected $fillable = [
                        'id',
                        'concentrator_id',
                        'num_client', 
                        'name',
                        'phone_number',
                        'email',
                        'address',
                        'rfc',
                        'cfdi',
                        'address_facture',
                        'shipping_address',
                        'shipping_reference',
                        'shipping_price',
                        'link_location',
                        'subtotal',
                        'iva',
                        'total',
                        'metodo_pago',
                        'status',
                        'user_id',
                        'observations',
                        ];
    public $incrementing = true;
}
