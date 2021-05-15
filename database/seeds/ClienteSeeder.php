<?php

use App\Models\Asignacion;
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
            'email'=>'perla123@gmail.com',
            'telefono'=>'9512647668',
            'telefonorespaldo'=>'9516356352',
            'direccion'=>'Direccion temporal', 
            'referencia'=>'Sin referencias', 
            'estatus'=>'Activo',
        ]);


        $contrato=Contrato::create([
            'num_contrato'=>'00783',
            'cliente_id'=>$cliente1->id, 
            'tipo_contrato'=>'PERMANENTE INDUSTRIAL',
            'precio_transporte'=>'1245.78',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'reguladores' => 1,
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida'=> 'Carga',
            'material' => 'Acero'
            ]); 

        $contrato=Contrato::create([
            'num_contrato'=>'00786',
            'cliente_id'=>$cliente2->id, 
            'tipo_contrato'=>'PERMANENTE INDUSTRIAL',
            'precio_transporte'=>'1245.78',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida' => 'Carga',
            'material' => 'Acero'
        ]);

        $contrato=Contrato::create([
            'num_contrato'=>'00787',
            'cliente_id'=>$cliente2->id, 
            'tipo_contrato'=>'PERMANENTE MEDICINAL',
            'precio_transporte'=>'180.50',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'reguladores' => 1,
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida' => 'Carga',
            'material' => 'Acero'
        ]);

        $contrato=Contrato::create([
            'num_contrato'=>'00788',
            'cliente_id'=>$cliente2->id, 
            'tipo_contrato'=>'EVENTUAL',
            'precio_transporte'=>'850',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida' => 'Carga',
            'material' => 'Acero'
        ]);

        $contrato=Contrato::create([
            'num_contrato'=>'00790',
            'cliente_id'=>$cliente3->id, 
            'tipo_contrato'=>'PERMANENTE INDUSTRIAL',
            'precio_transporte'=>'1245.78',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida' => 'Carga',
            'material' => 'Acero'
        ]);

        $contrato=Contrato::create([
            'num_contrato'=>'00791',
            'cliente_id'=>$cliente3->id, 
            'tipo_contrato'=>'PERMANENTE MEDICINAL',
            'precio_transporte'=>'180.50',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida' => 'Carga',
            'material' => 'Acero'
        ]);

        $contrato=Contrato::create([
            'num_contrato'=>'00792',
            'cliente_id'=>$cliente3->id, 
            'tipo_contrato'=>'EVENTUAL',
            'precio_transporte'=>'850',
            'direccion' => 'Plaza Crystal, Eduardo Mata, San José La Noria, 68120 Oaxaca de Juárez, Oax.',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'deposito_garantia' => 10000,
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>'3',
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'precio_unitario' => 200,
            'unidad_medida' => 'Carga',
            'material' => 'Acero'
        ]);
        
    }
}
