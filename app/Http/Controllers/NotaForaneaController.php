<?php

namespace App\Http\Controllers;
use App\Models\CatalogoGas;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\Models\NotaForanea;
use App\Models\NotaForaneaTanque;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;


class NotaForaneaController extends Controller
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
        if($this->slug_permiso('nota_foranea')){
            return view('notas.foranea.listado');
        }
        return view('home');
    }
    public function data(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        

        if($this->slug_permiso('nota_foranea')){

            if($user->soloParaUnRol('admin')){
                $notas=NotaForanea::all();
            }else{
                $notas=NotaForanea::where('user_id', auth()->user()->id);
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
            ->editColumn('pago_cubierto', function ($nota) {
                if($nota->pago_cubierto == true){
                    return 'Pagado';
                }else{
                    return 'Adeuda';
                }
            })
            ->editColumn('tanques_devueltos', function ($nota) {
                if($nota->tanques_devueltos == true){
                    return 'OK';
                }else{  
                    return 'Pendientes';
                }
            })
            ->addColumn( 'btnEdit', '<a class="btn btn-sm btn-verde" href="{{route(\'nota.foranea.edit\', $id)}}" data-toggle="tooltip" data-placement="top" title="Contrato"><span class="fas fa-edit"></span></a>')
            ->addColumn( 'btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.nota_foranea\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->rawColumns(['btnEdit', 'btnPDF'])
            ->toJson();
        }
        return view('home');
    }

    public function create(){   
        if($this->slug_permiso('nota_foranea')){
            return view('notas.foranea.create');
        }
        return view('home');
    }

    public function edit($id){

        $idauth=auth()->user()->id;
        $user=User::find($idauth);


        if($this->slug_permiso('nota_foranea') ){
            $catalogo = CatalogoGas::pluck('nombre','id');

            //listar tanquiers saldia
            $nota= NotaForanea::where('id', $id)->first();
            if($nota->user_id == $idauth || $user->soloParaUnRol('admin')){
                $tanques= NotaForaneaTanque::
                where('nota_foranea_id', $id)->where('insidencia','SALIDA')->get();
                $tanquesEntrada= NotaForaneaTanque::
                leftjoin('tanques','tanques.num_serie','=','notaforanea_tanque.num_serie')
                ->where('nota_foranea_id', $id)->where('insidencia','ENTRADA')->get();
    
                $data= ['catalogo' => $catalogo, 'tanques' =>$tanques, 'tanquesEntrada' =>$tanquesEntrada, 'nota'=> $nota];
                return view('notas.foranea.edit', $data);
            }
            return view('notas.foranea.listado');
        }
        return view('home');
    }

    public function salida_save(Request $request){
        if($this->slug_permiso('nota_foranea')){
            $request->validate([
                'nombre_cliente' => ['required', 'string', 'max:255'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'input-subtotal' => ['required', 'numeric'],
                'input-total' => ['required', 'numeric'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

                if(count($request->inputNumSerie) > 0 ){ ///validar si hay tanques en la lista
                    //Nota venta de envio
                    $venta= new NotaForanea;
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
                    if($request->metodo_pago  == 'Credito'){
                        $venta->pago_cubierto = false;
                    }
                    $venta->fecha = $fechaactual;
                    $venta->user_id = auth()->user()->id;
                    $venta->save();

                    foreach( $request->inputNumSerie AS $salid => $ent){
                                //Cambiar estatus tanque
                        $searhTanque =Tanque::where('num_serie', $request->inputNumSerie[$salid])->first(); 
                        $searhTanque->estatus='VENTA-FORANEA';
                        $searhTanque->save();

                        $historytanques=new TanqueHistorial();
                        $historytanques->num_serie = $request->inputNumSerie[$salid];
                        $historytanques->estatus = 'VENTA-FORANEA';
                        $historytanques->observaciones = 'Salida de tanque en venta foranea. Nota id:'. $venta->id;
                        $historytanques->user_id = auth()->user()->id;
                        $historytanques->save();
    
                        $ventatanque=new NotaForaneaTanque();
                        $ventatanque->nota_foranea_id = $venta->id;
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
                    return response()->json(['mensaje'=>'Registro-Correcto', 'notaId'=>$venta->id]);
                }
                return response()->json(['mensaje'=>'Error, No hay tanques que registrar']);

            
            
        }
        return view('home');
    }

    public function entrada_save(Request $request){
        if($this->slug_permiso('nota_foranea')){
            $venta= NotaForanea::find($request->idnota);
            $venta->telefono = $request->telefono;
            $venta->email = $request->email;
            $venta->direccion = $request->direccion;
            $venta->rfc = $request->rfc;
            $venta->cfdi = $request->cfdi;
            $venta->direccion_factura = $request->direccion_factura;
            $venta->pago_cubierto = $request->pago_cubierto;
            $venta->save();

            if($request->inputNumSerie_entrada){
                $searchRep = $request->inputNumSerie_entrada;
                if(count($searchRep) > count(array_unique($searchRep))){
                    return response()->json([ 'alert'=>'error', 'mensaje'=>'Cilindros repetidos en registro de entrada']);
                }
                if(count($request->inputNumSerie_entrada) >= count($request->inputNumSerie)){
                    $venta->tanques_devueltos = true;
                    $venta->save();
                }
                if(count($request->inputNumSerie_entrada) <= count($request->inputNumSerie)){
                    ///validar si hay tanques en la lista
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
                            $historytanques->observaciones = 'Entrada venta foranea. Nota id:'. $venta->id;
                            $historytanques->user_id = auth()->user()->id;
                            $historytanques->save();
                        }else{
                            //Si no existe registrar
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
                            $historytanques->observaciones = 'Registro nuevo tanque en venta foranea. Nota id:'. $venta->id;
                            $historytanques->user_id = auth()->user()->id;
                            $historytanques->save();
                        }
                        $ventatanque=new NotaForaneaTanque();
                        $ventatanque->nota_foranea_id = $request->idnota;
                        $ventatanque->num_serie = $request->inputNumSerie_entrada[$entrada];
                        $ventatanque->tapa_tanque = $request->inputTapa_entrada[$entrada];
                        $ventatanque->insidencia = 'ENTRADA';
                        $ventatanque->save();
                    }
                }
            }

            return response()->json(['alert'=>'success']);
            
            return false;
            //validar que no se encuentren numero de serie repetido
            

            // return response()->json(['alert'=>'error', 'mensaje'=>'La cantidad de tanques de entrada deben ser igual a los de salida']);
            // return response()->json(['alert'=>'error', 'mensaje'=>'No hay tanques que registrar']);
            
        }
        return view('home');
    }


    
}
