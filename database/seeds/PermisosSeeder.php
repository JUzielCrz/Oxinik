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
        
        //asignaciones
        Permissions::create([
            'name'=>'Aumento de cilindros',
            'slug'=>'asignacion_aumento',
            'description'=>'El usuario puede asignar cilindros a cliente',
        ]);
        Permissions::create([
            'name'=>'Disminución de cilindros ',
            'slug'=>'asignacion_disminucion',
            'description'=>'El usuario puede eliminar asignaciones de cilindros a cliente',
        ]);
        
        //Gases
        Permissions::create([
            'name'=>'Gases (Ver)',
            'slug'=>'gas_show',
            'description'=>'El usuario puede ver listado de tipo de gases',
        ]);
        Permissions::create([
            'name'=>'Gases (Crear)',
            'slug'=>'gas_create',
            'description'=>'El usuario puede crear un tipo de gas',
        ]);
        Permissions::create([
            'name'=>'Gases (Actualizar)',
            'slug'=>'gas_update',
            'description'=>'El usuario puede actualizar un tipo de gas',
        ]);
        Permissions::create([
            'name'=>'Gases (Eliminar)',
            'slug'=>'gas_delete',
            'description'=>'El usuario puede eliminar un tipo de gas',
        ]);

        //Clientes
        Permissions::create([
            'name'=>'Clientes (Ver)',
            'slug'=>'cliente_show',
            'description'=>'El usuario puede ver listado de clientes',
        ]);
        Permissions::create([
            'name'=>'Clientes (Crear)',
            'slug'=>'cliente_create',
            'description'=>'El usuario puede crear un cliente',
        ]);
        Permissions::create([
            'name'=>'Clientes (Actualizar)',
            'slug'=>'cliente_update',
            'description'=>'El usuario puede actualizar un cliente',
        ]);
        Permissions::create([
            'name'=>'Clientes (Eliminar)',
            'slug'=>'cliente_delete',
            'description'=>'El usuario puede eliminar un cliente',
        ]);

        //Contratos
        Permissions::create([
            'name'=>'Contratos (Ver)',
            'slug'=>'contrato_show',
            'description'=>'El usuario puede ver listado de contratos',
        ]);
        Permissions::create([
            'name'=>'Contratos (Crear)',
            'slug'=>'contrato_create',
            'description'=>'El usuario puede crear un contrato',
        ]);
        Permissions::create([
            'name'=>'Contratos (Actualizar)',
            'slug'=>'contrato_update',
            'description'=>'El usuario puede actualizar un contrato',
        ]);
        Permissions::create([
            'name'=>'Contratos (Eliminar)',
            'slug'=>'contrato_delete',
            'description'=>'El usuario puede eliminar un contrato',
        ]);

        //INFRA
        Permissions::create([
            'name'=>'INFRA (Salida)',
            'slug'=>'infra_salida',
            'description'=>'El usuario puede registra salida de cilindros a INFRA',
        ]);
        Permissions::create([
            'name'=>'INFRA (Entrada)',
            'slug'=>'infra_entrada',
            'description'=>'El usuario puede registra entrada de cilindros de INFRA',
        ]);
        
        //MANTENIMIENTO
        Permissions::create([
            'name'=>'mantenimiento (Salida)',
            'slug'=>'mantenimiento_salida',
            'description'=>'El usuario puede registra salida de cilindros a mantenimiento',
        ]);
        Permissions::create([
            'name'=>'mantenimiento (Entrada)',
            'slug'=>'mantenimiento_entrada',
            'description'=>'El usuario puede registra entrada de cilindros de mantenimiento',
        ]);
        
        //Notas
        Permissions::create([
            'name'=>'Notas (Ver)',
            'slug'=>'nota_show',
            'description'=>'El usuario puede visualizar listado de notas generadas',
        ]);
        Permissions::create([
            'name'=>'Notas Salida (Crear)',
            'slug'=>'nota_salida',
            'description'=>'El usuario puede generar notas de entrada de cilindros',
        ]);
        Permissions::create([
            'name'=>'Notas Entrada (Crear)',
            'slug'=>'nota_entrada',
            'description'=>'El usuario puede generar notas de salida de cilindros',
        ]);
        

        //Notas exporadicas
        Permissions::create([
            'name'=>'Nota Exporadica (Crear)',
            'slug'=>'nota_exporadica',
            'description'=>'El usuario puede generar notas de ventas exporadicas de cilindros',
        ]);

        //Tanques
        Permissions::create([
            'name'=>'Tanques (Ver)',
            'slug'=>'tanque_show',
            'description'=>'El usuario puede ver listado de Tanques',
        ]);
        Permissions::create([
            'name'=>'Tanques (Crear)',
            'slug'=>'tanque_create',
            'description'=>'El usuario puede crear un tanque',
        ]);
        Permissions::create([
            'name'=>'Tanques (Actualizar)',
            'slug'=>'tanque_update',
            'description'=>'El usuario puede actualizar un tanque',
        ]);
        Permissions::create([
            'name'=>'Tanques (Eliminar)',
            'slug'=>'tanque_delete',
            'description'=>'El usuario puede eliminar un tanque',
        ]);
        Permissions::create([
            'name'=>'Tanques (Visualizar Historial)',
            'slug'=>'tanque_history',
            'description'=>'El usuario puede visualizar el historial de un cinlindro',
        ]);
        Permissions::create([
            'name'=>'Tanques (Reportar)',
            'slug'=>'tanque_report',
            'description'=>'El usuario puede levantar reporte de un cinlindro',
        ]);

    }
}
