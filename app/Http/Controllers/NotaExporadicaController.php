<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\Models\VentaExporadica;
use App\Models\VentaTanque;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;

class NotaExporadicaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }
    


    public function index(){
        if($this->slug_permiso('nota_exporadica')){
            $catalogo = CatalogoGas::pluck('nombre','id');
            $data= ['catalogo' => $catalogo];
            return view('notas.mostrador.exporadica', $data);
        }
        return view('home');
    }

    public function save(Request $request){
        if($this->slug_permiso('nota_exporadica')){
            $request->validate([
                'nombre_cliente' => ['required', 'string', 'max:255'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'input-subtotal' => ['required', 'numeric'],
                'input-total' => ['required', 'numeric'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            if(count($request->inputNumSerie_entrada) == count($request->inputNumSerie)){
                if(count($request->inputNumSerie_entrada) > 0 || count($request->inputNumSerie) > 0 ){ ///validar si hay tanques en la lista
                    //Nota venta de envio
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
                    $venta->link_ubicacion_envio = $request->link_ubicacion_envio;
                    $venta->precio_envio = $request->precio_envio;
                    $venta->subtotal =  $request->input('input-subtotal');
                    $venta->iva_general = $request->input('input-ivaGen');;
                    $venta->total = $request->input('input-total');
                    $venta->metodo_pago = $request->metodo_pago;
                    $venta->fecha = $fechaactual;
                    $venta->user_id = auth()->user()->id;
                    
                        if($venta->save()){
                            //Guardar tanques Entrada
                            foreach( $request->inputNumSerie_entrada AS $entrada => $g){
                                $searhTanque =Tanque::where('num_serie', $request->inputNumSerie_entrada[$entrada])->first();
                                
                                // dump($searhTanque);
                                if($searhTanque){
                                    //si existe cambiar estatus del tanque 
                                    $searhTanque->estatus='VACIO-ALMACEN';
                                    $searhTanque->save();
                                    
                                    $historytanques=new TanqueHistorial();
                                    $historytanques->num_serie = $request->inputNumSerie_entrada[$entrada];
                                    $historytanques->estatus = 'VACIO-ALMACEN';
                                    $historytanques->observaciones = 'Entrada venta exporadica. Nota id:'. $venta->id;
                                    $historytanques->user_id = auth()->user()->id;
                                    $historytanques->save();
                                }else{
                                    //Si no existe registrar
                                    //	1 Carga, Acero, Praxair, Industrial, LLENO-ALMACEN, 2 ACETILENO
                                    $cadena=explode(', ', $request->inputDescripcion_entrada[$entrada]);
                                    $newTanque = new Tanque;
                                    $newTanque->num_serie = $request->inputNumSerie_entrada[$entrada];
                                    $newTanque->ph =$request->inputPh_entrada[$entrada];
                                    $newTanque->capacidad = $cadena[0];
                                    $newTanque->material = $cadena[1];
                                    $newTanque->fabricante = $cadena[2];
                                    $newTanque->tipo_tanque = $cadena[3];
                                    $newTanque->estatus = $cadena[4];
                                    $cadeGas =explode(' ',$cadena[5]);
                                    $newTanque->tipo_gas = $cadeGas[0];
                                    $newTanque->user_id = auth()->user()->id;
                                    $newTanque->save();
    
                                    $historytanques=new TanqueHistorial();
                                    $historytanques->num_serie = $request->inputNumSerie_entrada[$entrada];
                                    $historytanques->estatus = $cadena[4];
                                    $historytanques->observaciones = 'Registro nuevo tanque en venta exporadica. Nota id:'. $venta->id;
                                    $historytanques->user_id = auth()->user()->id;
                                    $historytanques->save();
                                }
                                
                                $ventatanque=new VentaTanque();
                                $ventatanque->venta_id = $venta->id;
                                $ventatanque->num_serie = $request->inputNumSerie_entrada[$entrada];
                                $ventatanque->insidencia = 'ENTRADA';
                                $ventatanque->save();
    
                            }
    
                            foreach( $request->inputNumSerie AS $salid => $ent){
                                //Cambiar estatus tanque
                                $searhTanque =Tanque::where('num_serie', $request->inputNumSerie[$salid])->first(); 
                                $searhTanque->estatus='VENTA-EXPORADICA';
                                $searhTanque->save();
    
                                $historytanques=new TanqueHistorial();
                                $historytanques->num_serie = $request->inputNumSerie[$salid];
                                $historytanques->estatus = 'VENTA-EXPORADICA';
                                $historytanques->observaciones = 'Salida de tanque en venta exporadica. Nota id:'. $venta->id;
                                $historytanques->user_id = auth()->user()->id;
                                $historytanques->save();
    
                                $ventatanque=new VentaTanque();
                                $ventatanque->venta_id = $venta->id;
                                $ventatanque->num_serie = $request->inputNumSerie[$salid];
                                $ventatanque->cantidad = $request->input_cantidad[$salid];
                                $ventatanque->unidad_medida = $request->input_unidad_medida[$salid];
                                $ventatanque->precio_unitario = $request->input_precio_unitario[$salid];
                                $ventatanque->tapa_tanque = $request->inputTapa[$salid];
                                $ventatanque->iva_particular = $request->input_iva_particular[$salid];
                                $ventatanque->importe = $request->input_importe[$salid];
                                $ventatanque->insidencia = 'SALIDA';
                                $ventatanque->save();
                            }
    
                            return response()->json(['alert'=>'success', 'notaId'=>$venta->id]);
                        }
                }
                return response()->json(['alert'=>'error', 'mensaje'=>'No hay tanques que registrar']);
            }
            return response()->json(['alert'=>'error', 'mensaje'=>'La cantidad de tanques de entrada deben ser igual a los de salida']);
            
            
        }
        return view('home');
    }


    public function listar(){
        if($this->slug_permiso('nota_exporadica')){
            return view('notas.mostrador.listar');
        }
        return view('home');
    }

    public function data(){
        if($this->slug_permiso('nota_exporadica')){
            $nota_entrada=VentaExporadica::all();
            return DataTables::of(
                $nota_entrada
            )                                                               
            ->editColumn('user_name', function ($nota) {
                if($nota->user_id == null){
                    return null;
                }else{
                    $usuario=User::select('name')->where('id', $nota->user_id)->first();
                    return $usuario->name;
                }
            })
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'pdf.nota_exporadica\', $id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->addColumn( 'btnShow', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'nota.exporadica.show\', $id)}}" title="Nota"><i class="far fa-eye"></i></a>')
            ->addColumn( 'btnCancelar', '<button class="btn btn-sm btn-verde btn-cancelar-salida" data-id="{{$id}}" title="Cancelar"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnNota', 'btnShow', 'btnCancelar'])
            ->toJson();
        }
        return view('home');
    }

    public function show ($id){
        if($this->slug_permiso('nota_salida')){
            
            $nota=VentaExporadica::find($id);
            $tanques=VentaTanque::
            join('tanques', 'tanques.num_serie','=','venta_tanque.num_serie' )
            ->select('venta_tanque.id as nota_id', 'venta_tanque.*', 'tanques.*')
            ->where('venta_tanque.venta_id', $nota->id)->get();
            
        $data=['nota'=>$nota,'tanques'=>$tanques];
        return view('notas.mostrador.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function salida_cancelar ($nota_id){
        if($this->slug_permiso('nota_salida')){
            $nota=VentaExporadica::find($nota_id);
            $nota->estatus = 'CANCELADA';
            $nota->save();
            $tanques=VentaTanque::where('nota_id', $nota->id)->get();

            foreach( $tanques AS $indice1 => $cilindro_ent){
                $tanq = Tanque::where('num_serie',$cilindro_ent->num_serie)->where('insidencia','ENTRADA')->first();
                $tanq->estatus = 'VENTA-EXPORADICA';
                $tanq->save();
            }

            foreach( $tanques AS $indice2 => $cilindro_sal){
                $tanq = Tanque::where('num_serie',$cilindro_sal->num_serie)->where('insidencia','SALIDA')->first();
                $tanq->estatus = 'LLENO-ALMACEN';
                $tanq->save();
            }
            
            return response()->json(['mensaje'=>'success']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

}
