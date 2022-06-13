<?php

namespace App\Http\Controllers;
use App\Models\CatalogoGas;
use App\Models\ClienteSinContrato;
use App\Models\Tanque;
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
                $notas=NotaForanea::
                select('nota_foranea.id as notaf_id', 'nota_foranea.*');
            }else{
                $notas=NotaForanea::
                select('nota_foranea.id as notaf_id', 'nota_foranea.*')
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
            ->editColumn('created_at', function ($infra) {
                return $infra->created_at->format('Y/m/d - H:i:s A');
            })
            ->addColumn( 'btnEdit', '<a class="btn btn-sm btn-verde" href="{{route(\'nota.foranea.edit\', $notaf_id)}}" data-toggle="tooltip" data-placement="top" title="Contrato"><span class="fas fa-edit"></span></a>')
            ->addColumn( 'btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.nota_foranea\', $notaf_id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->addColumn( 'btnDelete', '<button class="btn btn-sm btn-verde btn-eliminar-nota" data-id="{{$notaf_id}}" title="Eliminar"><span class="fas fa-trash"></span></button>')

            ->rawColumns(['btnEdit', 'btnPDF', 'btnDelete'])
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
                leftjoin('tanques','tanques.num_serie','=','notaforanea_tanque.num_serie')
                ->where('nota_foranea_id', $id)->where('insidencia','SALIDA')->get();
                $tanquesEntrada= NotaForaneaTanque::
                leftjoin('tanques','tanques.num_serie','=','notaforanea_tanque.num_serie')
                ->where('nota_foranea_id', $id)->where('insidencia','ENTRADA')->get();

                // $cliente=ClienteSinContrato::find($nota->cliente_id);
    
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
                'id_show' => ['required', 'numeric'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'input-subtotal' => ['required', 'numeric'],
                'input-total' => ['required', 'numeric'],
            ]);
            
            $fechaactual=date("Y")."-" . date("m")."-".date("d");

                if(count($request->inputNumSerie) > 0 ){ ///validar si hay tanques en la lista
                    
                    //Nota
                    $cliente = ClienteSinContrato::find($request->id_show);
                    //datos cliente
                    $venta= new NotaForanea;
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
                    if($request->metodo_pago  == 'Credito'){
                        $venta->pago_cubierto = false;
                    }
                    $venta->fecha = $fechaactual;
                    $venta->user_id = auth()->user()->id;
                    $venta->observaciones = $request->observaciones;
                    $venta->save();
                    
                    foreach( $request->inputNumSerie AS $salid => $ent){
                        
                        //Cambiar estatus tanque
                        $searhTanque =Tanque::where('num_serie', $request->inputNumSerie[$salid])->first(); 
                        $searhTanque->estatus='VENTA-FORANEA';
                        $searhTanque->save();
                        
                        $ventatanque=new NotaForaneaTanque();
                        $ventatanque->nota_foranea_id = $venta->id;
                        $ventatanque->num_serie = $request->inputNumSerie[$salid];
                        $ventatanque->cantidad = $request->input_cantidad[$salid];
                        $ventatanque->unidad_medida = $request->input_unidad_medida[$salid];                        
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
            //validaciones
            if($request->inputNumSerie_entrada != null){
                $searchRep = $request->inputNumSerie_entrada;
                if(count($searchRep) > count(array_unique($searchRep))){
                    return response()->json([ 'alert'=>'error', 'mensaje'=>'Cilindros repetidos en registro de entrada']);
                }
            }
            if($request->inputNumSerie != null){
                $searchRep = $request->inputNumSerie;
                if(count($searchRep) > count(array_unique($searchRep))){
                    return response()->json([ 'alert'=>'error', 'mensaje'=>'Cilindros repetidos en registro de entrada']);
                }
            }

            if($request->pago_cubierto == null){$pago=true;}else{$pago=$request->pago_cubierto;}
            
            $venta= NotaForanea::find($request->idnota);
            $venta->pago_cubierto = $pago;
            $venta->subtotal =  $request->input('input-subtotal');
            $venta->iva_general = $request->input('input-ivaGen');
            $venta->total = $request->input('input-total');
            $venta->tanques_devueltos = $request->input('tanques_devueltos');
            $venta->save();
            
            if($request->inputNumSerie != null){
                foreach( $request->inputNumSerie AS $salid => $ent){
                        //Cambiar estatus tanque
                        $searhTanque =Tanque::where('num_serie', $request->inputNumSerie[$salid])->first(); 
                        $searhTanque->estatus='VENTA-FORANEA';
                        $searhTanque->save();
    
                        $ventatanque=new NotaForaneaTanque();
                        $ventatanque->nota_foranea_id = $venta->id;
                        $ventatanque->num_serie = $request->inputNumSerie[$salid];
                        $ventatanque->cantidad = $request->input_cantidad[$salid];
                        $ventatanque->unidad_medida = $request->input_unidad_medida[$salid];
                        $ventatanque->precio_unitario = $request->input_importe[$salid];
                        $ventatanque->tapa_tanque = $request->inputTapa[$salid];
                        $ventatanque->iva_particular = $request->input_iva_particular[$salid];
                        $ventatanque->importe = $request->input_importe[$salid];
                        $ventatanque->insidencia = 'SALIDA';
                        $ventatanque->save();
                    
                    
                }
            }
            //entrada
            //Guardar tanques Entrada   serie_carga_salida
            if($request->inputNumSerie_entrada != null){
                foreach( $request->inputNumSerie_entrada AS $entrada => $g){
                    $searhTanque =Tanque::where('num_serie', $request->inputNumSerie_entrada[$entrada])->first();
                    if($searhTanque){
                        //si existe cambiar estatus del tanque 
                        $searhTanque->estatus='VACIO-ALMACEN';
                        $searhTanque->save();
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
                    }
    
                    $ventatanque=new NotaForaneaTanque();
                    $ventatanque->nota_foranea_id = $request->idnota;
                    $ventatanque->num_serie = $request->inputNumSerie_entrada[$entrada];
                    $ventatanque->tapa_tanque = $request->inputTapa_entrada[$entrada];
                    $ventatanque->insidencia = 'ENTRADA';
                    $ventatanque->save();
                }
            }
            
            return response()->json(['alert'=>'success']);
        }
        return view('home');
    }

    public function cambiar_estatus(Request $request, $num_serie){
        if($this->slug_permiso('nota_foranea')){
            NotaForaneaTanque::
            where('nota_foranea_id',$request->nota_id)
            ->where('insidencia','SALIDA')
            ->where('num_serie',$num_serie)
            ->delete();
            $cilindro=Tanque::where('num_serie',$num_serie)->first();
            $cilindro->estatus ='LLENO-ALMACEN';
            $cilindro->save();
            return response()->json(['alert'=>'success']);
        }
        return view('home');
    }

    public function cambiar_estatus_entrada(Request $request, $num_serie){
        if($this->slug_permiso('nota_foranea')){
            NotaForaneaTanque::
            where('nota_foranea_id',$request->nota_id)
            ->where('insidencia','ENTRADA')
            ->where('num_serie',$num_serie)
            ->delete();
            $cilindro=Tanque::where('num_serie',$num_serie)->first();
            $cilindro->estatus ='VENTA-FORANEA';
            $cilindro->save();
            return response()->json(['alert'=>'success']);
        }
        return view('home');
    }

    public function delete (NotaForanea $idnota){
        if($this->slug_permiso('nota_salida')){
            $tanques=NotaForaneaTanque::where('nota_foranea_id', $idnota->id)->get();

            foreach( $tanques AS $indice1 => $cilindro_ent){
                if($cilindro_ent->insidencia =='ENTRADA'){
                    $tanq = Tanque::where('num_serie',$cilindro_ent->num_serie)->first();
                    $tanq->estatus = 'VENTA-FORANEA';
                    $tanq->save();
                };
            }
            foreach( $tanques AS $indice1 => $cilindro_sal){
                if($cilindro_sal->insidencia =='SALIDA'){
                    $tanq = Tanque::where('num_serie',$cilindro_sal->num_serie)->first();
                    $tanq->estatus = 'LLENO-ALMACEN';
                    $tanq->save();
                };
            }
            $idnota->delete();
            return response()->json(['mensaje'=>'success']);
            
            return response()->json(['mensaje'=>'success']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    
}
