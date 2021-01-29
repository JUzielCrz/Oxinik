<?php

use App\Permissions;
use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        Permissions::create([
            'name'=>'CRUD Clientes',
            'slug'=>'clientes',
            'description'=>'El usuario puede listar, editar, eliminar clientes',
        ]);
        Permissions::create([
            'name'=>'CRUD Tanques',
            'slug'=>'tanques',
            'description'=>'El usuario puede listar, editar, eliminar tanques',
        ]);
        Permissions::create([
            'name'=>'CRUD Contratos',
            'slug'=>'contratos',
            'description'=>'El usuario puede listar, editar, eliminar contratos',
        ]);
    }
}
