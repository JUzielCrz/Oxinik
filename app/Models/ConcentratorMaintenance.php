<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcentratorMaintenance extends Model
{
    protected $fillable = [
                        'id',
                        'concentrator_id',
                        'serial_number',
                        'status',
                        'observations',
                        'user_id', 
                        ];
}
