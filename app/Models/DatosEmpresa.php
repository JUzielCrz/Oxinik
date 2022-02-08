<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosEmpresa extends Model
{
    protected $table = 'datos_empresa';
    public $timestamps =  false;
    protected $fillable = ['rfc','direccion', 'telefono1', 'telefono2', 'telefono3', 'num_cuenta1', 'clave1', 'banco1', 'titular1', 'num_cuenta2', 'clave2', 'banco2', 'titular2'];
    public $incrementing = true;
}
