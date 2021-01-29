<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps =  true;
    protected $fillable = ['id','apPaterno','apMaterno', 'nombre','rfc','email','telefono','telefonorespaldo','direccion', 'referencia', 'estatus'];
    public $incrementing = true;
}