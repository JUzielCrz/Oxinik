<?php

use App\Models\Asignacion;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Nota;
use App\Models\NotaTanque;
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
            'num_contrato'=>'1',
            'cliente_id'=>$cliente1->id, 
            'tipo_contrato'=>'Industrial',
            'nombre_comercial'=>'Los 3 Garcias',
            'precio_transporte'=>'250',
            'direccion' => 'Plan de Ayala 305, FERROCARRIL, Agencia de Policia de Cinco Señores, 68145 Oaxaca de Juárez, Oax.',
            'calle1'=>'Aldama Martirez',
            'calle1'=>'Guillermo Prieto',
            'referencia' => 'Porton rojo, a una cuadra de AV. Lazaro Cardenas',
            'link_ubicacion' => 'https://goo.gl/maps/qPBLWWL4Z43Z7f6s7',
            'reguladores' => 1,
            'observaciones' => 'Cliente distinguido',
            'modelo_regulador' => 'kn123',
        ]);
        Asignacion::create([
            'contratos_id'=>$contrato->id,
            'cilindros'=>1,
            'tipo_gas'=>1,
            'tipo_tanque' => 'Industrial',
            'material' => 'Acero',
            'precio_unitario' => 200,
            'unidad_medida'=> 'Carga',
            'capacidad' => 1,
            ]); 

        Nota::create([
            'contrato_id' =>1,   
            'fecha' =>'2021-12-17',  
            'envio' =>200,  
            'subtotal' =>20160,  
            'iva_general' =>3840,  
            'total' =>24000,  
            'primer_pago' =>24000,  
            'metodo_pago' =>'Efectivo',  
            'pago_cubierto' =>1,  
            'observaciones' =>'',
            'user_id' =>1, 
            'estatus' =>'ACTIVA',   

        ]);
        NotaTanque::create([
            'nota_id'=> 1,
            'num_serie'=> 'TQ00245',
            'cantidad'=> 1,
            'unidad_medida'=> 'CARGA',
            'precio_unitario'=> '6000',
            'tapa_tanque'=> 'SI',
            'iva_particular'=> 960,
            'importe'=> 6000,
            'estatus'=> 'PENDIENTE',
        ]);       
        NotaTanque::create([
            'nota_id'=> 1,
            'num_serie'=> 'AL00245',
            'cantidad'=> 1,
            'unidad_medida'=> 'CARGA',
            'precio_unitario'=> '6000',
            'tapa_tanque'=> 'SI',
            'iva_particular'=> 960,
            'importe'=> 6000,
            'estatus'=> 'PENDIENTE',
        ]);  
        NotaTanque::create([
            'nota_id'=> 1,
            'num_serie'=> 'AL00249',
            'cantidad'=> 1,
            'unidad_medida'=> 'CARGA',
            'precio_unitario'=> '6000',
            'tapa_tanque'=> 'SI',
            'iva_particular'=> 960,
            'importe'=> 6000,
            'estatus'=> 'PENDIENTE',
        ]);  
        NotaTanque::create([
            'nota_id'=> 1,
            'num_serie'=> 'AL00250',
            'cantidad'=> 1,
            'unidad_medida'=> 'CARGA',
            'precio_unitario'=> '6000',
            'tapa_tanque'=> 'SI',
            'iva_particular'=> 960,
            'importe'=> 6000,
            'estatus'=> 'PENDIENTE',
        ]);   
    }
}
