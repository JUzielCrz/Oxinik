<?php

use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cliente1=Cliente::create([
            'apPaterno'=>'García',
            'apMaterno'=>'Cruz', 
            'nombre'=>'Fabián',
            'rfc'=>'AOCU654GHBH786SD',
            'email'=>'fabcruz@gmail.com',
            'telefono'=>'9512635668',
            'telefonorespaldo'=>'9516352556',
            'direccion'=>'Direccion temporal', 
            'referencia'=>'Sin referencias', 
            'estatus'=>'Activo',
        ]);

        $cliente2=Cliente::create([
            'apPaterno'=>'Martínez',
            'apMaterno'=>'Angeles', 
            'nombre'=>'Raul',
            'rfc'=>'AOCU654GH57542SD',
            'email'=>'raul@gmail.com',
            'telefono'=>'9512658668',
            'telefonorespaldo'=>'9516522556',
            'direccion'=>'Direccion temporal', 
            'referencia'=>'Sin referencias', 
            'estatus'=>'Activo',
        ]);

        $cliente3=Cliente::create([
            'apPaterno'=>'Ángeles',
            'apMaterno'=>'Martínez', 
            'nombre'=>'Perla',
            'rfc'=>'AOCU654GHBH711SD',
            'email'=>'fabcruz@gmail.com',
            'telefono'=>'9512647668',
            'telefonorespaldo'=>'9516356352',
            'direccion'=>'Direccion temporal', 
            'referencia'=>'Sin referencias', 
            'estatus'=>'Activo',
        ]);


        Contrato::create([
            'num_contrato'=>'00783',
            'cliente_id'=>$cliente1->id, 
            'tipo_contrato'=>'PERMANENTE INDUSTRIAL',
            'precio_transporte'=>'1245.78',
        ]);
        Contrato::create([
            'num_contrato'=>'00784',
            'cliente_id'=>$cliente1->id, 
            'tipo_contrato'=>'PERMANENTE MEDICINAL',
            'precio_transporte'=>'180.50',
        ]);
        Contrato::create([
            'num_contrato'=>'00785',
            'cliente_id'=>$cliente1->id, 
            'tipo_contrato'=>'EVENTUAL',
            'precio_transporte'=>'850',
        ]);
        Contrato::create([
            'num_contrato'=>'00786',
            'cliente_id'=>$cliente2->id, 
            'tipo_contrato'=>'PERMANENTE INDUSTRIAL',
            'precio_transporte'=>'1245.78',
        ]);
        Contrato::create([
            'num_contrato'=>'00787',
            'cliente_id'=>$cliente2->id, 
            'tipo_contrato'=>'PERMANENTE MEDICINAL',
            'precio_transporte'=>'180.50',
        ]);
        Contrato::create([
            'num_contrato'=>'00788',
            'cliente_id'=>$cliente2->id, 
            'tipo_contrato'=>'EVENTUAL',
            'precio_transporte'=>'850',
        ]);
        Contrato::create([
            'num_contrato'=>'00790',
            'cliente_id'=>$cliente3->id, 
            'tipo_contrato'=>'PERMANENTE INDUSTRIAL',
            'precio_transporte'=>'1245.78',
        ]);
        Contrato::create([
            'num_contrato'=>'00791',
            'cliente_id'=>$cliente3->id, 
            'tipo_contrato'=>'PERMANENTE MEDICINAL',
            'precio_transporte'=>'180.50',
        ]);
        Contrato::create([
            'num_contrato'=>'00792',
            'cliente_id'=>$cliente3->id, 
            'tipo_contrato'=>'EVENTUAL',
            'precio_transporte'=>'850',
        ]);
    }
}
