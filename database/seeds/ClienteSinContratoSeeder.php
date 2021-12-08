<?php

use App\Models\ClienteSinContrato;
use Illuminate\Database\Seeder;

class ClienteSinContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClienteSinContrato::create([
            'nombre'=>'Fabián Hernandez',
            'email'=>'fabcruz@gmail.com',
            'telefono'=>'9512635668',
            'direccion'=>'Direccion temporal', 
            'rfc'=>'AOCU654GHBH786SD',
            'cfdi'=>'GASTOS VARIOS',
            'direccion_factura'=>'Libramiento Sur No.100, San Sebastian Tutla, 68150 San Sebastián Tutla, Oax.',
            'direccion_envio'=>'Libramiento Sur No.100, San Sebastian Tutla, 68150 San Sebastián Tutla, Oax.',
            'referencia_envio'=>'Universidad Regional Del Sureste URSE Campus Rosario', 
            'link_ubicacion_envio'=>'https://goo.gl/maps/m1Zc97SqhWEuYSxx9', 
            'precio_envio'=>200, 
        ]);

        ClienteSinContrato::create([
            'nombre'=>'Hernesto Amparo',
            'email'=>'fabcruz@gmail.com',
            'telefono'=>'9512635668',
            'direccion'=>'Direccion temporal', 
            'rfc'=>'AOCU654GHBH786SD',
            'cfdi'=>'GASTOS VARIOS',
            'direccion_factura'=>'Libramiento Sur No.100, San Sebastian Tutla, 68150 San Sebastián Tutla, Oax.',
            'direccion_envio'=>'Libramiento Sur No.100, San Sebastian Tutla, 68150 San Sebastián Tutla, Oax.',
            'referencia_envio'=>'Universidad Regional Del Sureste URSE Campus Rosario', 
            'link_ubicacion_envio'=>'https://goo.gl/maps/m1Zc97SqhWEuYSxx9', 
            'precio_envio'=>200, 
        ]);

        ClienteSinContrato::create([
            'nombre'=>'Hernesto Jimenez Arellanes',
            'email'=>'fabcruz@gmail.com',
            'telefono'=>'9512635668',
            'direccion'=>'Direccion temporal', 
            'rfc'=>'AOCU654GHBH786SD',
            'cfdi'=>'GASTOS VARIOS',
            'direccion_factura'=>'Libramiento Sur No.100, San Sebastian Tutla, 68150 San Sebastián Tutla, Oax.',
            'direccion_envio'=>'Libramiento Sur No.100, San Sebastian Tutla, 68150 San Sebastián Tutla, Oax.',
            'referencia_envio'=>'Universidad Regional Del Sureste URSE Campus Rosario', 
            'link_ubicacion_envio'=>'https://goo.gl/maps/m1Zc97SqhWEuYSxx9', 
            'precio_envio'=>200, 
        ]);
    }
}
