<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concentrator extends Model
{
    protected $table = 'concentrators';
    public $timestamps =  true;
    protected $fillable = [
                        'id',
                        'serial_number',
                        'brand',
                        'work_hours', 
                        'capacity',
                        'description',
                        ];
    public $incrementing = true;
}
