<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEntrada extends Model
{
    protected $table = 'notas_entrada';
    public $timestamps =  true;
    protected $fillable = [
        'id',
        'contrato_id', 
        'metodo_pago', 
        'recargos', 
        'observaciones'];
    public $incrementing = true;

    // public function notas(){
    //     return $this->belongsToMany('App\Models\Tanque')->withTimestamps();
    // }
}
