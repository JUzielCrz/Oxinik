<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Models\Concentrator;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

     //crear usuario administrador
        $useradmin=User::create([
            'name'      => 'ADMIN OXINIK',
            'email'     =>  'sge.oxinik@gmail.com',
            'email_verified_at'     =>  '2020-01-17 13:00:00',
            'password'  => Hash::make('oxinik#2020'),
        ]);

        //Creacion de Rol para Administrador
            $roladmin= Role::create([
                'name'=>'Admin',
                'slug'=>'admin',
                'description'=>'Administrador',
            ]);
        //crear relacion en la tabla rol_user para admin
        $useradmin->roles()->sync([$roladmin->id]);
     //end

     Concentrator::create([
        'serial_number'=>'123',
        'brand'=>'Beker',
        'work_hours'=>'5000', 
        'capacity'=>'38',
        'status'=>'ALMACEN',
        'description'=>'SIN DESCRIPCION POR EL MOMENTO',
    ]);
    Concentrator::create([
        'serial_number'=>'234',
        'brand'=>'RANGER',
        'work_hours'=>'5000', 
        'capacity'=>'45',
        'status'=>'ALMACEN',
        'description'=>'SIN DESCRIPCION POR EL MOMENTO',
    ]);

    }
}