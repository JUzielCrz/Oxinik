<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcentratorPayments extends Model
{
    protected $table = 'concentrator_payments';
    public $timestamps =  true;
    protected $fillable = [
        'note_id',

        'day',
        'price_day',
        'week',
        'price_week',
        'mount',
        'price_mount',
        
        'deposit_garanty',
        'date_start',
        'date_end',

        'shipping_address',
        'shipping_reference',
        'shipping_price',
        'link_location',
        'work_hours_output',

        'total',
        'status',
        'payment_method',

        'observations',
        'user_id',
    ];
    public $incrementing = true;
}
