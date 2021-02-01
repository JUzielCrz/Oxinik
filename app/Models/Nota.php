<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';
    public $timestamps =  true;
    protected $fillable = ['id','folio_nota','fecha', 'pago_realizado','metodo_pago', 'num_contrato'];
    public $incrementing = true;

    public function notas(){
        return $this->belongsToMany('App\Models\Tanque')->withTimestamps();
    }

}
