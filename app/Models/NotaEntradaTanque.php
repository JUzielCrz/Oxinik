<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEntradaTanque extends Model
{
    protected $table = 'notas_entrada_tanque';
    public $timestamps =  true;
    protected $fillable = ['nota_id','num_serie', 'tapa_tanque', 'intercambio'];
}
