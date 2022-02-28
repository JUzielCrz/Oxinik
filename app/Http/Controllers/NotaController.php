<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Cliente;
use App\Models\Contrato; 
use App\Models\Nota;
use App\Models\NotaEntrada;
use App\Models\NotaEntradaTanque;
use App\Models\NotaPagos;
use App\Models\NotaTanque;
use App\Models\Tanque;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NotaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }

    public function salidas(){
        if($this->slug_permiso('nota_salida')){
            return view('notas.contrato.salidas');
        }
        return view('home');
    }

    public function salida_show ($nota_id){
        if($this->slug_permiso('nota_salida')){
            $nota=Nota::find($nota_id);
            $tanques=NotaTanque::
            join('tanques', 'tanques.num_serie','=','nota_tanque.num_serie' )
            ->where('nota_id', $nota->id)->get();
            $contrato=Contrato::where('id', $nota->contrato_id)->first();
            $cliente=Cliente::where('id', $contrato->cliente_id)->first();
            $pagos=NotaPagos::where('nota_id',$nota_id)->get();

        $data=['nota'=>$nota,'tanques'=>$tanques, 'contrato'=>$contrato, 'cliente'=>$cliente, 'pagos'=>$pagos];
        return view('notas.contrato.salida_show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function salida_cancelar ($nota_id){
        if($this->slug_permiso('nota_salida')){
            $nota=Nota::find($nota_id);
            $nota->estatus = 'CANCELADA';
            $nota->save();
            $tanques=NotaTanque::where('nota_id', $nota->id)->get();

            foreach( $tanques AS $indice => $cilindro){
                $tanq = Tanque::where('num_serie',$cilindro->num_serie)->first();
                $tanq->estatus = 'LLENO-ALMACEN';
                $tanq->save();
            }
            
            return response()->json(['mensaje'=>'success']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function search_contrato(Request $request){
        if($request->get('query')){
            $query = $request->get('query');
            $data=Contrato::
            join('clientes','clientes.id','=','contratos.cliente_id')
            ->select('clientes.nombre', 'clientes.apPaterno', 'clientes.apMaterno', 'contratos.id','contratos.tipo_contrato','clientes.empresa')
            ->where('clientes.estatus', 'ACTIVO')
            ->where('contratos.id', 'LIKE', "%{$query}%")
            ->orWhere(DB::raw("CONCAT(clientes.nombre,' ', clientes.apPaterno,' ', clientes.apMaterno )"),'LIKE', "%{$query}%")
            ->orWhere('clientes.empresa', 'LIKE', "%{$query}%")
            ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">'; 

            foreach($data as $row) {
                $output .= '<li><a href="#">'.$row->id.', '.$row->nombre.' '.$row->apPaterno.', '.$row->empresa.', '.$row->tipo_contrato.'</a></li>'; 
            }

            $output .= '</ul>'; echo $output;
        }
    }

    public function data_contrato($contrato_id){
        $contrato=Contrato::
        join('clientes','clientes.id','=','contratos.cliente_id')
        ->select('contratos.id as contrato_id', 'contratos.*','clientes.*')
        ->where('contratos.id', $contrato_id)->first();
        
        $num_asignacion= Asignacion::where('contratos_id', $contrato->id)->get() ;

        return response()->json(['contrato' => $contrato,'num_asignacion' => $num_asignacion->sum('cantidad')]);
    }

    public function nota_data($contrato_id){
            $notas=Nota::
            select('notas.*')->where('contrato_id',$contrato_id);
            return DataTables::of(
                $notas
            )
            ->editColumn('created_at', function ($infra) {
                return $infra->created_at->format('Y/m/d - H:i:s A');
            })
            ->editColumn('pago_cubierto', function ($nota) {
                if($nota->pago_cubierto== true){
                    return 'Pagado';
                }else{
                    return 'Adeuda';
                }
            })
            ->addColumn( 'btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.nota_salida\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->rawColumns(['btnPDF'])
            ->toJson();
    }

    public function salida_validar_tanqueasignacion(Request $request){

        $tanque=Tanque::where('num_serie',$request->num_serie)->first();
        $asignaciones= Asignacion::
        where('contratos_id', $request->contrato_id)
        ->where('tipo_gas', $tanque->tipo_gas)
        ->where('tipo_tanque', $tanque->tipo_tanque)
        ->where('material', $tanque->material)
        ->first();

        if($asignaciones){
            return response()->json(['mensaje'=>true]);
        }else{
            return response()->json(['mensaje'=>false]);
        }
    }

    public function salida_save(Request $request){        
        if($this->slug_permiso('nota_salida')){
            $request->validate([
                'contrato_id' => ['required'],
                'input-total' => ['required', 'numeric'],
                'monto_pago' => ['required', 'numeric'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

            if(count($request->inputNumSerie) > 0){ ///validar si hay tanques en la lista
                $pagocubierto=false;
                if(floatval($request->input('monto_pago')) >= floatval( $request->input('input-total'))){
                    $pagocubierto=true;
                }   
                $notas = new Nota;
                $notas->contrato_id = $request->input('contrato_id');
                $notas->fecha = $fechaactual;
                $notas->envio = $request->input('precio_envio');
                $notas->subtotal = $request->input('input-subtotal');
                $notas->iva_general = $request->input('input-ivaGen');
                $notas->total = $request->input('input-total');
                $notas->pago_cubierto =  $pagocubierto;
                $notas->primer_pago = $request->input('monto_pago');
                $notas->metodo_pago = $request->input('metodo_pago');
                $notas->observaciones =  $request->observaciones;
                $notas->user_id = auth()->user()->id;

                if($notas->save()){
                    if($pagocubierto == false){
                        $pagos = new NotaPagos;
                        $pagos->nota_id = $notas->id;
                        $pagos->monto_pago = $request->input('monto_pago');
                        $pagos->metodo_pago = $request->input('metodo_pago');
                        $pagos->save();
                    }

                    foreach( $request->inputNumSerie AS $series => $g){
                        $notaTanque=new NotaTanque;
                        $notaTanque->nota_id =  $notas->id;
                        $notaTanque->num_serie = $request->inputNumSerie[$series];
                        $notaTanque->cantidad = $request->input_cantidad[$series];
                        $notaTanque->unidad_medida = $request->input_unidad_medida[$series];
                        $notaTanque->precio_unitario = $request->input_precio_unitario[$series];
                        $notaTanque->tapa_tanque = $request->inputTapa[$series];
                        $notaTanque->iva_particular = $request->input_iva_particular[$series];
                        $notaTanque->importe = $request->input_importe[$series];
                        $notaTanque->save();

                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'ENTREGADO-CLIENTE';
                        $tanque->save();
                    }
                }
                return response()->json(['mensaje'=>'Registrado Correctamente', 'notaId'=>$notas->id]);
            }
            return response()->json(['mensaje'=>'Error, No hay tanques que registrar']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function save_envio(Request $request, $contrato_id){
        if($this->slug_permiso('nota_salida')){
            $envio = Contrato::where('id',$contrato_id)->first();
            $envio->precio_transporte = $request->precio_transporte;
            $envio->direccion = $request->direccion;
            $envio->referencia = $request->referencia;
            $envio->save();
            return $envio; 
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    //Metodos nota entrada
    public function entradas(){
        
        if($this->slug_permiso('nota_entrada')){
            return view('notas.contrato.entrada');
        }
        return view('home');
    }

    public function tanques_pendientes($contrato_id){
        $notatanque=Nota::
        join('nota_tanque','nota_tanque.nota_id','=','notas.id')
        ->select(
            'notas.id as nota_id',
            'nota_tanque.num_serie',
            'notas.fecha',
            'nota_tanque.tapa_tanque',
            )
        ->addSelect(['tanque_id' => tanque::select('id')->whereColumn( 'nota_tanque.num_serie', 'tanques.num_serie')])
        ->addSelect(['tanque_desc' => tanque::select(DB::raw("CONCAT(ph,', ', capacidad,', ', material,', ',fabricante,', ',tipo_tanque)"))->whereColumn( 'nota_tanque.num_serie', 'tanques.num_serie')])
        ->where('contrato_id', $contrato_id)
        ->where('nota_tanque.estatus', 'PENDIENTE')
        ->orderBy('num_serie')
        ->get();
        return  $notatanque;
    }

    public function save_entrada(Request $request){

        if($this->slug_permiso('nota_entrada')){

            $request->validate([
                'input-total' => ['required', 'numeric'],
                'contrato_id' => ['required', 'numeric'],
            ]);

            if(count($request->inputNumSerie) > 0){ ///validar si hay tanques en la lista
                $notas = new NotaEntrada();
                $notas->contrato_id = $request->input('contrato_id');
                $notas->metodo_pago = $request->input('metodo_pago');
                $notas->recargos = $request->input('input-total');
                $notas->observaciones = $request->input('observaciones');
                $notas->user_id = auth()->user()->id;
                $notas->save();

                    foreach( $request->inputNumSerie AS $series => $g){
                        //buscar tanque en inventario
                        $searhTanque =Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        
                        if($searhTanque){//si existe 
                            //cambia estatus del tanque
                            $searhTanque->estatus='VACIO-ALMACEN';
                            $searhTanque->save();
                            if($request->inputCambio[$series] == 'SN'){
                                $NoTanqueId=NotaTanque::
                                join('notas', 'nota_tanque.nota_id','notas.id')
                                ->select('nota_tanque.id as nota_tanque_id')
                                ->where('nota_tanque.estatus','PENDIENTE')
                                ->where('num_serie',  $request->inputNumSerie[$series])
                                ->where('contrato_id',$request->input('contrato_id'))
                                ->first();
                                $cambiar_estatus = NotaTanque::find($NoTanqueId->nota_tanque_id);
                                $cambiar_estatus->estatus='DEVUELTO';
                                $cambiar_estatus->save();
                            }
                        }else{//SI CILINDRO NO EXISTE
                            //Registrar nuevo tanque
                            $cadena=explode(', ', $request->inputDescripcion[$series]);
                            $newTanque = new Tanque;
                            $newTanque->num_serie =$request->inputNumSerie[$series];
                            $newTanque->ph =$request->inputPh[$series];
                            $newTanque->capacidad = $cadena[0];
                            $newTanque->material = $cadena[1];
                            $newTanque->fabricante = $cadena[2];
                            $newTanque->tipo_tanque = $cadena[3];
                            $newTanque->estatus = $cadena[4];
                            $cadenaGas=explode(' ', $cadena[5]);
                            $newTanque->tipo_gas = $cadenaGas[0];
                            $newTanque->user_id = auth()->user()->id;
                            $newTanque->save();
                        }

                        if($request->inputCambio[$series] != 'SN'){//entra si el tanque SI se cambio
                            
                            $NoTanqueId=NotaTanque::
                                join('notas', 'nota_tanque.nota_id','notas.id')
                                ->select('nota_tanque.id as nota_tanque_id')
                                ->where('nota_tanque.estatus','PENDIENTE')
                                ->where('num_serie', $request->inputCambio[$series])
                                ->where('contrato_id',$request->input('contrato_id'))
                                ->first();
                                $cambiar_estatus = NotaTanque::find($NoTanqueId->nota_tanque_id);
                                $cambiar_estatus->estatus='CAMBIADO';
                                $cambiar_estatus->save();

                            //cambiar estatus del tanque cambiado
                            $intercambiotanq =Tanque::where('num_serie',$request->inputCambio[$series])->first();
                            $intercambiotanq->estatus='TANQUE-CAMBIADO';
                            $intercambiotanq->save();
                        }

                        $notaTanque=new NotaEntradaTanque();
                        $notaTanque->nota_id =  $notas->id;
                        $notaTanque->num_serie = $request->inputNumSerie[$series];
                        $notaTanque->tapa_tanque = $request->inputTapa[$series];
                        $notaTanque->intercambio = $request->inputCambio[$series];
                        $notaTanque->save();    
                    }
                    return response()->json(['mensaje'=>'Regsitro Correcto']);
                
            }
            return response()->json(['mensaje'=>'Error, No hay tanques que registrar']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function entrada_show ($nota_id){
        
        if($this->slug_permiso('nota_entrada')){
            $nota=NotaEntrada::find($nota_id);
            $tanques=NotaEntradaTanque::
            join('tanques', 'tanques.num_serie','=','notas_entrada_tanque.num_serie' )
            ->where('nota_id', $nota->id)->get();
            $contrato=Contrato::where('id', $nota->contrato_id)->first();
            $cliente=Cliente::where('id', $contrato->cliente_id)->first();
            $pagos=NotaPagos::where('nota_id',$nota_id)->get();
        $data=['nota'=>$nota,'tanques'=>$tanques, 'contrato'=>$contrato, 'cliente'=>$cliente, 'pagos'=>$pagos];
        return view('notas.contrato.entrada_show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function entrada_cancelar ($nota_id){
        if($this->slug_permiso('nota_entrada')){
            $nota=NotaEntrada::find($nota_id);
            $nota->estatus = 'CANCELADA';
            $nota->save();
            $tanques=NotaEntradaTanque::where('nota_id', $nota->id)->get();

            foreach( $tanques AS $indice => $cilindro){
                $tanq = Tanque::where('num_serie',$cilindro->num_serie)->first();
                $tanq->estatus = 'ENTREGADO-CLIENTE';
                $tanq->save();
            }
            
            return response()->json(['mensaje'=>'success']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


}




