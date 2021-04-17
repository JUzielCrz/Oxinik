<?php

// namespace App\Http\Controllers;

// use App\Models\Tanque;
// use App\Models\TanqueHistorial;
// use App\Models\Venta;
// use App\Models\VentaTanque;
// use App\User;
// use Illuminate\Http\Request;
// use Yajra\DataTables\DataTables;

// class VentaController extends Controller
// {
    

    


//     public function validventasalida($numserie){
//         if($this->slugpermision()){
//             $buscartanque=Tanque::where('num_serie',$numserie)->first();
//             if($buscartanque->estatus == 'LLENO-ALMACEN'){
//                 return response()->json(['mensaje'=>true]);
//             } 
//             return false;
//         }
//         return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
//     }

//     public function create(Request $request)
//     {        
//         if($this->slugpermision()){

//             $request->validate([
//                 'cliente' => ['required', 'string', 'max:255'],
//                 'telefono' => ['required', 'int'],
//                 'email' => ['required', 'email', 'string', 'max:255'],
//                 'direccion' => ['required', 'string', 'max:255'],
//             ]);

//             if(count($request->registronum_serie) > 0 && count($request->salidanum_serie) > 0){
                

//                 $ventas=new Venta;
//                 $ventas->cliente = $request->input('cliente');
//                 $ventas->telefono = $request->input('telefono');
//                 $ventas->email = $request->input('email');
//                 $ventas->direccion = $request->input('direccion');
//                 $ventas->rfc = $request->input('rfc');
//                 $ventas->cfdi = $request->input('cfdi');
//                 $ventas->direccion_factura = $request->input('direccion_factura');
//                 $ventas->metodo_pago = $request->input('metodo_pago');
//                 if($ventas->save()){
//                     ///Guardar datos tanques de entrada
//                     foreach( $request->registronum_serie AS $series => $g){
                        
//                         if(Tanque::find($request->registronum_serie[$series])){
//                             $tanque=Tanque::find($request->registronum_serie[$series]);
//                             $tanque->num_serie = $request->registronum_serie[$series];
//                             $tanque->ph = $request->registroph[$series];
//                             $tanque->capacidad = $request->registrocapacidad[$series];
//                             $tanque->material = $request->registromaterial[$series];
//                             $tanque->fabricante = $request->registrofabricante[$series];
//                             $tanque->tipo_gas = $request->registrotipogas[$series];
//                             $tanque->estatus = 'VACIO-ALMACEN';
//                             $tanque->save();
//                         }else{
//                             $tanque=new Tanque;
//                             $tanque->num_serie = $request->registronum_serie[$series];
//                             $tanque->ph = $request->registroph[$series];
//                             $tanque->capacidad = $request->registrocapacidad[$series];
//                             $tanque->material = $request->registromaterial[$series];
//                             $tanque->fabricante = $request->registrofabricante[$series];
//                             $tanque->tipo_gas = $request->registrotipogas[$series];
//                             $tanque->estatus = 'VACIO-ALMACEN';
//                             $tanque->save();
//                         }
//                             $Vtanque=new VentaTanque;
//                             $Vtanque->venta_id=$ventas->id;
//                             $Vtanque->num_serie=$request->registronum_serie[$series];
//                             $Vtanque->insidencia='ENTRADA';
//                             $Vtanque->save();

//                             $historytanques=new TanqueHistorial;
//                             $historytanques->num_serie = $request->registronum_serie[$series];
//                             $historytanques->estatus = 'VACIO-ALMACEN';
//                             $historytanques->folios = 'ID Venta: '.$ventas->id;
//                             $historytanques->save();
//                     }


//                     ///Guardar datos tanques de SALIDA
//                     foreach( $request->salidanum_serie AS $series => $g){
//                         $Vtanque=new VentaTanque;
//                         $Vtanque->venta_id=$ventas->id;
//                         $Vtanque->num_serie=$request->salidanum_serie[$series];
//                         $Vtanque->precio=$request->salidaPrecio[$series];
//                         $Vtanque->tapa_tanque=$request->salidaTapa[$series];
//                         $Vtanque->regulador=$request->salidaRegulador[$series];
//                         $Vtanque->insidencia='SALIDA';
//                         $Vtanque->save();

                        
//                         $tanque=Tanque::where('num_serie',$request->salidanum_serie[$series])->first();
//                         $tanque->estatus = 'VENTA-EXPORADICA';
//                         $tanque->save();

//                         $historytanques=new TanqueHistorial;
//                         $historytanques->num_serie = $request->salidanum_serie[$series];
//                         $historytanques->estatus = 'VENTA-EXPORADICA';
//                         $historytanques->folios = 'ID Venta: '.$ventas->id;
//                         $historytanques->save();
//                     }
                    
//                 }
//                 return response()->json(['mensaje'=>'Registrado Correctamente']);
//             }
//             return response()->json(['mensaje'=>'No existen tanques que registrar']);
//         }
//         return response()->json(['mensaje'=>'Sin permisos']);
//     }

// }
