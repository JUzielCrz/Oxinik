<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    protected $table = 'tanques';
    public $timestamps =  true;
    protected $fillable = ['id','num_serie','ph', 'capacidad','material', 'fabricante', 'tipo_gas', 'tipo_tanque','estatus','user_id'];
    public $incrementing = true;

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
