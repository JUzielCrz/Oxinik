<?php

// namespace App\Http\Controllers;

// use App\Models\Tanque;
// use App\Models\VentaExporadica;
// use App\User;
// use Yajra\DataTables\DataTables;
// use Illuminate\Http\Request;

// class VentaExporadicaController extends Controller
// {
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

//     public function slugpermision(){
//         $idauth=auth()->user()->id;
//         $user=User::find($idauth);

//         return $user->havePermission('ventas');
//     }
    
//     public function list_table()
//     {
//         if($this->slugpermision()){
//             return view( 'venta_exporadica.list_table');
//         }
//         return view('home');
//     }

//     public function datatablesindex(){
//         if($this->slugpermision()){
//             $ventas=VentaExporadica::
//             select('ventas.*');
//             return DataTables::of(
//                 $ventas
//             )
//             ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
//             ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
//             ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
//             ->rawColumns(['btnShow','btnEdit','btnDelete'])
//             ->toJson();
//         }
//         return view('home');
//     }



//     public function newventa(){
//         if($this->slugpermision()){
//             return view( 'venta_exporadica.newventa');
//         }
//         return view('home');
//     }


//     public function validar_existencia($numserie){
//         if($this->slugpermision()){
//             $tanque=Tanque::where('num_serie',$numserie)
//             ->first();
            
//             if($tanque){
//                 if($tanque->estatus == 'VACIO-ALMACEN' || $tanque->estatus=='LLENO-ALMACEN'||$tanque->estatus=='INFRA'||$tanque->estatus=='MANTENIMIENTO' ){
//                     return response()->json(['mensaje'=>'tanque-en-almacen', 'tanqueEstatus'=>$tanque->estatus]);
//                 }
//                 return response()->json(['mensaje'=>$tanque]);

//             }else{
//                 return response()->json(['mensaje'=>'alert-danger']);
//             }
//         }
//         return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
//     }


// }
