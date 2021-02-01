<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaTanque extends Model
{
    protected $table = 'nota_tanque';
    public $timestamps =  true;
    protected $fillable = ['folio_nota','num_serie', 'precio', 'regulador', 'tapa_tanque'];
    // public $incrementing = true;
}
