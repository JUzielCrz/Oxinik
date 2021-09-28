<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanqueReportado extends Model
{
    
    protected $table = 'tanques_reportados';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie', 'observaciones'];
    public $incrementing = true;

}

