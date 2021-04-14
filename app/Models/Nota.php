<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';
    public $timestamps =  true;
    protected $fillable = ['id','contrato_id', 'folio_nota','fecha', 'envio', 'subtotal', 'iva_general', 'total', 'pago_cubierto', 'recargos', 'incidencia'];
    public $incrementing = true;

    public function notas(){
        return $this->belongsToMany('App\Models\Tanque')->withTimestamps();
    }

}
