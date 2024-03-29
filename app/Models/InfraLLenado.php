<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfraLLenado extends Model
{
    protected $table = 'infra_llenado';
    public $timestamps =  true;
    protected $fillable = ['id','fecha','cantidad', 'incidencia'];
    public $incrementing = true;
}

