<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoGases extends Model
{
    protected $table = 'catalogo_gases';
    public $timestamps =  false;
    protected $fillable = ['id','nombre','abreviatura'];
    public $incrementing = true;
}