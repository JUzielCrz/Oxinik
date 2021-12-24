<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
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



        //$useradmin=User::create([
        //    'name'      => 'Trabajador 1',
        //    'email'     =>  'trabajador1_oxinik@gmail.com',
        //    'email_verified_at'     =>  '2020-01-17 13:00:00',
        //    'password'  => Hash::make('trabajador1'),
        //]);
        //$roladmin= Role::create([
        //    'name'=>'Gerente de ventas',
        //    'slug'=>'GerenteVentas',
        //   'description'=>'Quien realiza las ventas',
        //]);
        //crear relacion en la tabla rol_user para admin
        //$useradmin->roles()->sync([$roladmin->id]);

    
    }
}