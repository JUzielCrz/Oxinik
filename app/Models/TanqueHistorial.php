<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanqueHistorial extends Model
{
    
    protected $table = 'tanque_historial';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie', 'estatus', 'folios'];
    public $incrementing = true;

}
