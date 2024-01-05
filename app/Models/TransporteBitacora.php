<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransporteBitacora extends Model
{
    protected $table = 'transporte_bitacoras';
    protected $fillable = ['id','lugar_salida', 'lugar_llegada', 'hora_salida', 'hora_entrada', 'descarga', 'carga', 'total'];
}
