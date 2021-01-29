<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaTanque extends Model
{
    protected $table = 'nota_tanque';
    public $timestamps =  true;
    protected $fillable = ['nota_id','tanque_id', 'tapa_tanque'];
    // public $incrementing = true;
}
