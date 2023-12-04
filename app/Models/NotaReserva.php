<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaReserva extends Model
{
    protected $table = 'nota_reserva';
    public $timestamps =  true;
    protected $fillable = ['id',
                        'user_id',
                        'incidencia',
                        'driver',
                        'car',
                        ];
    public $incrementing = true;
}
