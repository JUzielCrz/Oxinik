<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use App\Models\VentaExporadica;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class VentaExporadicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->havePermission('ventas');
    }
    
    public function list_table()
    {
        if($this->slugpermision()){
            return view( 'venta_exporadica.list_table');
        }
        return view('home');
    }

    public function datatablesindex(){
        if($this->slugpermision()){
            $ventas=VentaExporadica::
            select('ventas.*');
            return DataTables::of(
                $ventas
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }



    public function newventa(){
        if($this->slugpermision()){
            return view( 'venta_exporadica.newventa');
        }
        return view('home');
    }


    public function validar_existencia($numserie){
        if($this->slugpermision()){
            $tanque=Tanque::where('num_serie',$numserie)
            ->first();
            
            if($tanque){
                if($tanque->estatus == 'VACIO-ALMACEN' || $tanque->estatus=='LLENO-ALMACEN'||$tanque->estatus=='INFRA'||$tanque->estatus=='MANTENIMIENTO' ){
                    return response()->json(['mensaje'=>'tanque-en-almacen', 'tanqueEstatus'=>$tanque->estatus]);
                }
                return response()->json(['mensaje'=>$tanque]);

            }else{
                return response()->json(['mensaje'=>'alert-danger']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }


    public function validar_existencia_salida($numserie){
        if($this->slugpermision()){
            $buscartanque=Tanque::where('num_serie',$numserie)->first();
            if($buscartanque->estatus == 'LLENO-ALMACEN'){
                return response()->json(['mensaje'=>true]);
            } 
            return false;
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function save_venta(Request $request){
        $request->validate([
            'nombre_cliente' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'metodo_pago' => ['required', 'string', 'max:255'],

            'input-subtotal' => ['required', 'numeric'],
            'input-total' => ['required', 'numeric'],
            'monto_pago' => ['required', 'numeric'],
            
        ]);

        $fechaactual=date("Y")."-" . date("m")."-".date("d");

        if(count($request->inputNumSerie) > 0){ ///validar si hay tanques en la lista
            $venta= new VentaExporadica;
            $venta->nombre_cliente = $request->nombre_cliente;
            $venta->telefono = $request->telefono;
            $venta->email = $request->email;
            $venta->direccion = $request->direccion;
            $venta->rfc = $request->rfc;
            $venta->cfdi = $request->cfdi;
            $venta->direccion_factura = $request->direccion_factura;
            $venta->direccion_envio = $request->direccion_envio;
            $venta->referencia_envio = $request->referencia_envio;
            $venta->precio_envio = $request->precio_envio;
            $venta->subtotal = $request->subtotal;
            $venta->iva_general = $request->iva_general;
            $venta->total = $request->total;
            $venta->metodo_pago = $request->metodo_pago;
            $venta->fecha = $fechaactual;
                if($venta->save()){
                    foreach( $request->inputNumSerie_entrada AS $entrada => $g){
                        $searhTanque =Tanque::where('num_serie',$request->inputNumSerie_entrada[$entrada])->first();
                        if($searhTanque){
                            //si existe cambiar estatus del tanque 
                            $searhTanque->estatus='VACIO-ALMACEN';
                            $searhTanque->save();
                        }else{
                            //Si no existe registrar
                            $cadena=explode(', ', $request->inputDescripcion[$entrada]);
                            $newTanque = new Tanque;
                            $newTanque->ph =$request->inputPh[$entrada];
                            $newTanque->capacidad = $cadena[1];
                            $newTanque->material = $cadena[2];
                            $newTanque->fabricante = $cadena[3];
                            $newTanque->tipo_gas = $cadena[4];
                            $newTanque->estatus = 'VACIO-ALMACEN';
                            $newTanque->save();
                        }

                        $notaTanque=new Vent;
                        $notaTanque->nota_id =  $notas->id;
                        $notaTanque->num_serie = $request->inputNumSerie[$entrada];
                        $notaTanque->tapa_tanque = $request->inputTapa[$entrada];
                        $notaTanque->save();

                        $historytanques=new TanqueHistorial;
                        $historytanques->num_serie = $request->inputNumSerie[$entrada];
                        $historytanques->estatus = 'VACIO-ALMACEN';
                        $historytanques->folios ='NOTA:'. $notas->id;
                        $historytanques->save();
                    }
                }
        return response()->json(['mensaje'=>'Error, No hay tanques que registrar']);
    
    }








    }
}
