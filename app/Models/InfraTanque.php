<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfraTanque extends Model
{
    protected $table = 'infra_tanques';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie','infrallenado_id'];
    public $incrementing = true;
}

