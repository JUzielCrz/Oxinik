<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcentratorNote extends Model
{
    protected $table = 'concentrator_notas';
    public $timestamps =  true;
    protected $fillable = [
                        'id',
                        'num_client', 
                        'name',
                        'phone_number',
                        'email',
                        'address',
                        'rfc',
                        'cfdi',
                        'address_facture',

                        'concentrator_id',

                        'user_id',
                        'observations',

                        ];
    public $incrementing = true;
}
