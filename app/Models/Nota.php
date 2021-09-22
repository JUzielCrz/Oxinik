<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';
    public $timestamps =  true;
    protected $fillable = [
        'id',
        'contrato_id', 
        'fecha', 
        'envio', 
        'subtotal', 
        'iva_general', 
        'total', 
        'primer_pago', 
        'metodo_pago',
        'pago_cubierto',
        'observaciones'];
    public $incrementing = true;

    // public function notas(){
    //     return $this->belongsToMany('App\Models\Tanque')->withTimestamps();
    // }

}
