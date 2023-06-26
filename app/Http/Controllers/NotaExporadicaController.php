<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\ClienteSinContrato;
use App\Models\Tanque;
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
                'id_show' => ['required', 'numeric'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'input-subtotal' => ['required', 'numeric'],
                'input-total' => ['required', 'numeric'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            if(count($request->inputNumSerie_entrada) == count($request->inputNumSerie)){
                if(count($request->inputNumSerie_entrada) > 0 || count($request->inputNumSerie) > 0 ){ ///validar si hay tanques en la lista
                    //Nota
                    $cliente=ClienteSinContrato::find($request->id_show);
                    $venta= new VentaExporadica;
                     //datos cliente
                    $venta->num_cliente = $cliente->id;
                    $venta->nombre = $cliente->nombre;
                    $venta->telefono = $cliente->telefono;
                    $venta->email = $cliente->email;
                    $venta->direccion = $cliente->direccion;
                    $venta->rfc = $cliente->rfc;
                    $venta->cfdi = $cliente->cfdi;
                    $venta->direccion_factura = $cliente->direccion_factura;
                    $venta->direccion_envio = $cliente->direccion_envio;
                    $venta->referencia_envio = $cliente->referencia_envio;
                    $venta->link_ubicacion_envio = $cliente->link_ubicacion_envio;
                    $venta->precio_envio = $cliente->precio_envio;

                    $venta->subtotal =  $request->input('input-subtotal');
                    $venta->iva_general = $request->input('input-ivaGen');
                    $venta->total = $request->input('input-total');
                    $venta->metodo_pago = $request->metodo_pago;
                    $venta->fecha = $fechaactual;
                    $venta->observaciones = $request->observaciones;
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
    
                                $ventatanque=new VentaTanque();
                                $ventatanque->venta_id = $venta->id;
                                $ventatanque->num_serie = $request->inputNumSerie[$salid];
                                $ventatanque->cantidad = $request->input_cantidad[$salid];
                                $ventatanque->unidad_medida = $request->input_unidad_medida[$salid];
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
            ->editColumn('created_at', function ($infra) {
                return $infra->created_at->format('Y/m/d - H:i:s A');
            })
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'pdf.nota_exporadica\', $id)}}" title="Nota"><i class="fas fa-file-pdf"></i></a>')
            ->addColumn( 'btnShow', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'nota.exporadica.show\', $id)}}" title="Nota"><i class="far fa-eye"></i></a>')
            ->addColumn( 'btnCancelar', '<button class="btn btn-sm btn-verde btn-cancelar" data-id="{{$id}}" title="Cancelar"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnNota', 'btnShow', 'btnCancelar'])
            ->toJson();
        }
        return view('home');
    }

    public function show ($id){
        
        if($this->slug_permiso('nota_salida')){
            
        $nota=VentaExporadica::find($id);
        $cliente=ClienteSinContrato::find($nota->num_cliente);
        $tanques=VentaTanque::
        join('tanques', 'tanques.num_serie','=','venta_tanque.num_serie' )
        ->select('venta_tanque.id as nota_id', 'venta_tanque.*', 'tanques.*')
        ->where('venta_tanque.venta_id', $nota->id)->get();
            
        $data=['nota'=>$nota,'tanques'=>$tanques, 'cliente'=>$cliente];
            return view('notas.mostrador.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function salida_cancelar ($nota_id){
        
        if($this->slug_permiso('nota_salida')){
            $nota=VentaExporadica::find($nota_id);
            $nota->estatus = 'CANCELADA';
            $nota->save();
            $tanques=VentaTanque::where('venta_id', $nota->id)->get();

            foreach( $tanques AS $indice1 => $cilindro_ent){
                if($cilindro_ent->insidencia =='ENTRADA'){
                    $tanq = Tanque::where('num_serie',$cilindro_ent->num_serie)->first();
                    $tanq->estatus = 'VENTA-EXPORADICA';
                    $tanq->save();
                };
            }

            foreach( $tanques AS $indice2 => $cilindro_sal){
                if($cilindro_sal->insidencia =='SALIDA'){
                    $tanq = Tanque::where('num_serie',$cilindro_sal->num_serie)->first();
                    $tanq->estatus = 'LLENO-ALMACEN';
                    $tanq->save();
                };
            }
            
            return response()->json(['mensaje'=>'success']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


}
