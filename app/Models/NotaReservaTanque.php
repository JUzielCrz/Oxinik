<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaReservaTanque extends Model
{
    protected $table = 'nota_reserva_tanque';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie','nota_id'];
    public $incrementing = true;
}
