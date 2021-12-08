<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\ClienteSinContrato;
use App\Models\NotaTalon;
use App\Models\NotaTalonTanque;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;

class NotaTalonController extends Controller
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
        if($this->slug_permiso('nota_talon')){
            return view('notas.talon.listado');
        }
        return view('home');
    }
    public function data(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        

        if($this->slug_permiso('nota_talon')){

            if($user->soloParaUnRol('admin')){
                $notas=NotaTalon::
                join('clientes_sin_contrato', 'nota_talon.cliente_id','=', 'clientes_sin_contrato.id');

            }else{
                $notas=NotaTalon::
                join('clientes_sin_contrato', 'nota_talon.cliente_id','=', 'clientes_sin_contrato.id')
                ->where('user_id', auth()->user()->id);
            }

            return DataTables::of(
                $notas
            )
            ->editColumn('user_name', function ($user) {
                if($user->user_id == null){
                    return null;
                }else{
                    $nombre=User::select('name')->where('id', $user->user_id)->first();
                    return $nombre->name;
                }
            })
            ->addColumn( 'btnEdit', '<a class="btn btn-sm btn-verde" href="{{route(\'nota.talon.edit\', $id)}}" data-toggle="tooltip" data-placement="top" title="Contrato"><span class="fas fa-edit"></span></a>')
            ->rawColumns(['btnEdit'])
            ->toJson();
        }
        return view('home');
    }

    public function create(){   
        if($this->slug_permiso('nota_talon')){
            $catalogo = CatalogoGas::pluck('nombre','id');
            $data= ['catalogo' => $catalogo];

            return view('notas.talon.create', $data);
        }
        return view('home');
    }

    public function create_save(Request $request){

        if($this->slug_permiso('nota_talon')){
            $request->validate([
                'id_show' => ['required', 'numeric'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'input-subtotal' => ['required', 'numeric'],
                'input-total' => ['required', 'numeric'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

                if(count($request->inputNumSerie_entrada) > 0 ){ ///validar si hay tanques en la lista
                    //Nota venta de envio
                    $venta= new NotaTalon;
                    $venta->cliente_id = $request->id_show;
                    $venta->precio_envio=$request->precio_envio_nota;
                    $venta->subtotal =  $request->input('input-subtotal');
                    $venta->iva_general = $request->input('input-ivaGen');;
                    $venta->total = $request->input('input-total');
                    $venta->metodo_pago = $request->metodo_pago;
                    $venta->fecha = $fechaactual;
                    $venta->user_id = auth()->user()->id;
                    $venta->save();

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
                        
                        $ventatanque=new NotaTalonTanque();
                        $ventatanque->nota_talon_id = $venta->id;
                        $ventatanque->num_serie = $request->inputNumSerie_entrada[$entrada];
                        $ventatanque->cantidad = $request->inputCantidad[$entrada];
                        $ventatanque->unidad_medida = $request->inputUnidad_medida[$entrada];
                        $ventatanque->precio_unitario = $request->inputPrecio_unitario[$entrada];
                        $ventatanque->tapa_tanque = $request->inputTapa_entrada[$entrada];
                        $ventatanque->iva_particular = $request->input_iva_particular[$entrada];
                        $ventatanque->importe = $request->input_importe[$entrada];
                        $ventatanque->insidencia = 'ENTRADA';
                        $ventatanque->save();
                    }
                    return response()->json(['mensaje'=>'Registro-Correcto', 'notaId'=>$venta->id]);
                }
                return response()->json(['mensaje'=>'Error, No hay tanques que registrar']);
        }
        return view('home');
    }

    public function edit($id){

        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if($this->slug_permiso('nota_talon') ){
            //listar tanquiers saldia
            $nota= NotaTalon::where('id', $id)->first();
            if($nota->user_id == $idauth || $user->soloParaUnRol('admin')){
                $tanques= NotaTalonTanque::
                leftjoin('tanques','tanques.num_serie','=','nota_talontanque.num_serie')
                ->where('nota_talon_id', $id)->where('insidencia','SALIDA')->get();
                $tanquesEntrada= NotaTalonTanque::
                leftjoin('tanques','tanques.num_serie','=','nota_talontanque.num_serie')
                ->where('nota_talon_id', $id)->where('insidencia','ENTRADA')->get();
                $cliente=ClienteSinContrato::find($nota->cliente_id);
    
                $data= ['tanques' =>$tanques, 'tanquesEntrada' =>$tanquesEntrada, 'nota'=> $nota,'cliente'=> $cliente];
                return view('notas.talon.edit', $data);
            }
            return view('notas.talon.listado');
        }
        return view('home');
    }

    public function edit_save(Request $request){
        if($this->slug_permiso('nota_talon')){
            //validar que no se encuentren numero de serie repetido
            $searchRep = $request->inputNumSerie_salida;

            if(count($searchRep) > count(array_unique($searchRep))){
                return response()->json([ 'alert'=>'error', 'mensaje'=>'Cilindros repetidos en registro de salida']);
            }


            if(count($request->inputNumSerie_salida) <= count($request->inputNumSerie_entrada)){
                if(count($request->inputNumSerie_salida) > 0 || count($request->inputNumSerie_entrada) > 0 ){ ///validar si hay tanques en la lista
                    //Nota venta de envio
                    $venta= NotaTalon::find($request->idnota);
                    $client= ClienteSinContrato::find($venta->cliente_id);
                    $client->telefono = $request->telefono;
                    $client->email = $request->email;
                    $client->direccion = $request->direccion;
                    $client->rfc = $request->rfc;
                    $client->cfdi = $request->cfdi;
                    $client->direccion_factura = $request->direccion_factura;
                    $client->save();

                    //Guardar tanques salida
                    foreach( $request->inputNumSerie_salida AS $salid => $ent){
                        //Cambiar estatus tanque
                        $searhTanque =Tanque::where('num_serie', $request->inputNumSerie_salida[$salid])->first(); 
                        $searhTanque->estatus='VENTA-TALON';
                        $searhTanque->save();

                        $ventatanque=new NotaTalonTanque();
                        $ventatanque->nota_talon_id = $venta->id;
                        $ventatanque->num_serie = $request->inputNumSerie_salida[$salid];
                        $ventatanque->tapa_tanque = $request->inputTapa[$salid];
                        $ventatanque->insidencia = 'SALIDA';
                        $ventatanque->save();
                    }
    
                    return response()->json(['alert'=>'success', 'notaId'=>$request->idnota]);
                        
                }
                return response()->json(['alert'=>'error', 'mensaje'=>'No hay tanques que registrar']);
            }
            return response()->json(['alert'=>'error', 'mensaje'=>'La cantidad de tanques de salida deben ser igual a los de entrada']);
            
            
        }
        return view('home');
    }


}
