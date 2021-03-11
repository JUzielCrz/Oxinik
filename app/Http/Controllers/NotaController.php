<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\ContratoAsignacionTanques;
use App\Models\Nota;
use App\Models\NotaPagos;
use App\Models\Notas;
use App\Models\NotaTanque;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NotaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->havePermission('contratos');
    }
    

    public function datatablesindex($numContrato){
        if($this->slugpermision()){
            $notas=Nota::
            select('notas.*')->where('num_contrato',$numContrato);
            return DataTables::of(
                $notas
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btnnota-show-modal btn-xs" data-id="{{$folio_nota}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnDevolucion', '<button class="btn btn-grisclaro btnnota-devolucion btn-xs" data-id="{{$folio_nota}}"><span class="fas fa-undo"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-naranja btnnota-edit btn-xs" data-id="{{$folio_nota}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btnnota-delete-modal btn-xs" data-id="{{$folio_nota}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnShow','btnDevolucion','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }


    public function notasalida(){
        return view('notas.notasalida');
    }

    public function searchcontrato(Request $request){
        if($request->get('query')){

            $query = $request->get('query');

            // $data = DB::table('contratos') ->where('num_contrato', 'LIKE', "%{$query}%")->get();
            
            $data=Contrato::
            join('clientes','clientes.id','=','contratos.cliente_id')
            ->where('num_contrato', 'LIKE', "%{$query}%")
            ->orWhere(DB::raw("CONCAT(clientes.nombre,' ', clientes.apPaterno,' ', clientes.apMaterno )"),'LIKE', "%{$query}%")
            ->get();


            $output = '<ul class="dropdown-menu" style="display:block; position:relative">'; 

            foreach($data as $row) {
                $output .= '<li><a href="#">'.$row->num_contrato.', '.$row->nombre.' '.$row->apPaterno.' '.$row->apMaterno.', '.$row->tipo_contrato.'</a></li>'; 
            }

            $output .= '</ul>'; echo $output;
        }
    }

    public function datacontrato($num_contrato)
    {
        $contrato= 
        Contrato::
        join('clientes','clientes.id','=','contratos.cliente_id')
        ->where('num_contrato', $num_contrato)->first();
        
        return response()->json(['contrato' => $contrato]);
    }


    public function create(Request $request)
    {        
        if($this->slugpermision()){
            dump($request->all());
            $request->validate([
                'folio_nota' => ['required', 'string', 'max:255', 'unique:notas,folio_nota'],
                // 'fecha' => ['required'],
                'num_contrato' => ['required', 'string', 'max:255'],
                'inp_total' => ['required', 'numeric'],
                'monto_pago' => ['required', 'numeric'],
            ]);
            
            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            
            if(count($request->inputNumSerie) > 0){

                $notas = new Nota;
                $notas->folio_nota = $request->input('folio_nota');
                $notas->fecha = $fechaactual;
                $notas->num_contrato = $request->input('num_contrato');
                $notas->envio = $request->input('precio_envio');
                $notas->total = $request->input('inp_total');

                

                if($notas->save()){
                    
                    $pagos = new NotaPagos;
                    $pagos->folio_nota = $notas->folio_nota;
                    $pagos->monto_pago = $request->input('monto_pago');
                    $pagos->metodo_pago = $request->input('metodo_pago');
                    $pagos->save();

                    foreach( $request->inputNumSerie AS $series => $g){
                        $notaTanque=new NotaTanque;
                        $notaTanque->folio_nota = $request->input('folio_nota');
                        $notaTanque->num_serie = $request->inputNumSerie[$series];
                        $notaTanque->precio = $request->inputPrecio[$series];
                        // $notaTanque->regulador = $request->inputRegulador[$series];
                        $notaTanque->tapa_tanque = $request->inputTapa[$series];
                        $notaTanque->save();

                        $historytanques=new TanqueHistorial;
                        $historytanques->num_serie = $request->inputNumSerie[$series];
                        $historytanques->estatus = 'ENTREGADO-CLIENTE';
                        $historytanques->folios ='#Nota: '. $request->input('folio_nota');
                        $historytanques->save();

                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'ENTREGADO-CLIENTE';
                        $tanque->save();
                    }
                }
            }
            return response()->json(['mensaje'=>'Registrado Correctamente', 'notaId'=>$notas->id]);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }



    public function saveeditenvio(Request $request, $num_contrato){
        if($this->slugpermision()){
            $envio = Contrato::where('num_contrato',$num_contrato)->first();
            $envio->precio_transporte = $request->precio_transporte;
            $envio->direccion = $request->direccion;
            $envio->referencia = $request->referencia;
            $envio->save();
            return $envio; 
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function saveasignacion(Request $request, $num_contrato){
        if($this->slugpermision()){

            $contrato = Contrato::where('num_contrato',$num_contrato)->first();
        
            if($request->incidencia == 'AUMENTO'){
                
                $suma= $contrato->asignacion_tanques + $request->contidadtanques;
            }else{
                
                $suma= $contrato->asignacion_tanques - $request->contidadtanques;
            }

            if($suma > 0){
                $contrato->asignacion_tanques = $suma;
                if($contrato->save()){
                    $fechaactual=date("Y")."-" . date("m")."-".date("d");

                    $asignacion= new ContratoAsignacionTanques;
                    $asignacion->num_contrato=$num_contrato;
                    $asignacion->cantidad=$request->contidadtanques;
                    $asignacion->incidencia=$request->incidencia;
                    $asignacion->fecha= $fechaactual;
                    $asignacion->save();
                    return response()->json(['alert'=>'alert-primary','num_asignacion'=>$contrato->asignacion_tanques, 'id_asignacion' => $asignacion->id]);
                }
            }
            return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Asignacion no puede ser menor igual a 0']);
        }
        return response()->json(['Sin permisos']);
    }









    //rescatar


    public function notaentrada(){
        return view('notas.notaentrada');
    }


    public function newnota($numContrato){
        if($this->slugpermision()){
            $idcliente=Contrato::where('num_contrato',$numContrato)->first();
            $data = ['numContrato'=>$numContrato,  'idcliente'=>$idcliente->cliente_id];
            return view( 'notas.newnota', $data);
        }
        return view('home');
    }

    public function insertfila($serietanque){
        if($this->slugpermision()){
            if($tanques=Tanque::where('num_serie',$serietanque)->first() ){
                return response()->json(['tanque' => $tanques, 'alert' => true]);
            }
            return response()->json(['tanque' => $tanques, 'alert' => false]);
        }
        return view('home');
    }



    

    public function editnota($folionota){
        if($this->slugpermision()){
            $notas= Nota::where('folio_nota',$folionota)->first();

            $notasTanques= NotaTanque:: 
            join('tanques', 'tanques.num_serie','nota_tanque.num_serie')
            ->where('folio_nota', $notas->folio_nota)->where('devolucion', false)->get();

            $idcliente=Contrato::where('num_contrato',$notas->num_contrato)->first();

            $data=['notas'=>$notas, 'notasTanques' =>$notasTanques, 'idcliente'=>$idcliente->cliente_id ];
            return view('notas.edit',$data );
        }
    }

    public function devolucionnota($folionota){
        if($this->slugpermision()){
            $notas= Nota::where('folio_nota',$folionota)->first();

            $notasTanques= NotaTanque:: 
            join('tanques', 'tanques.num_serie','nota_tanque.num_serie')
            ->where('folio_nota', $notas->folio_nota)->where('devolucion', false)
            ->get();

            $devolucionTanques= NotaTanque:: 
            join('tanques', 'tanques.num_serie','nota_tanque.num_serie')
            ->where('folio_nota', $notas->folio_nota)->where('devolucion', true)
            ->get();

            $idcliente=Contrato::where('num_contrato',$notas->num_contrato)->first();

            $data=['notas'=>$notas, 'notasTanques' =>$notasTanques, 'idcliente'=>$idcliente->cliente_id, 'devolucionTanques'=>$devolucionTanques  ];
            return view('notas.devolucion',$data );
        }
    }

    public function savedevolucionnota(Request $request, $idNota){
        
        $notas=Nota::find($idNota);

        if($request->inputNumSerie != 0){
            NotaTanque::where('folio_nota',$notas->folio_nota)->where('devolucion', true)->delete();


            foreach( $request->inputNumSerie AS $series => $g){
                $notaTanque=new NotaTanque;
                $notaTanque->folio_nota =  $notas->folio_nota;
                $notaTanque->num_serie = $request->inputNumSerie[$series];
                $notaTanque->multa = $request->inputMulta[$series];
                // $notaTanque->regulador = $request->inputRegulador[$series];
                $notaTanque->tapa_tanque = $request->inputTapa[$series];
                $notaTanque->devolucion = true;
                $notaTanque->save();  

                $cadena=explode(', ', $request->inputDescripcion[$series]);
                if($cadena[0] == 'intercambio'){
                    if(Tanque::where('num_serie',$request->inputNumSerie[$series])->first()){
                        $tanques=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanques->ph =$cadena[1];
                        $tanques->capacidad = $cadena[2];
                        $tanques->material = $cadena[3];
                        $tanques->fabricante = $cadena[4];
                        $tanques->tipo_gas = $cadena[5];
                        $tanques->estatus = 'VACIO-ALMACEN';
                        $tanques->save();

                    }else{
                        $newtanque= new Tanque;
                        $newtanque->num_serie = $request->inputNumSerie[$series];
                        $newtanque->ph =$cadena[1];
                        $newtanque->capacidad = $cadena[2];
                        $newtanque->material = $cadena[3];
                        $newtanque->fabricante = $cadena[4];
                        $newtanque->tipo_gas = $cadena[5];
                        $newtanque->estatus = 'VACIO-ALMACEN';
                        $newtanque->save();
                    }
                }

                $estatustanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                $estatustanque->estatus = 'VACIO-ALMACEN';
                $estatustanque->save();

                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $request->inputNumSerie[$series];
                $historytanques->estatus = 'VACIO-ALMACEN';
                $historytanques->folios = '#Nota: '. $notas->folio_nota;
                $historytanques->save();

                
            }
            
            return response()->json(['mensaje'=>'Regsitro Correcto']);
        }
        return response()->json(['mensaje'=>'No hay registros']);
    }

    public function update(Request $request , $idNota)
    {        
        if($this->slugpermision()){ 

            $request->validate([
                'folio_nota' => ['required', 'string','max:255', Rule::unique('notas')->ignore($idNota, 'id')],
                'fecha' => ['required'],
                'pago_realizado' => ['required', 'string', 'max:255'],
                // 'metodo_pago' => ['required', 'string', 'max:255'],
                'num_contrato' => ['required', 'string', 'max:255'],
                'inputTotal' => ['required'],
            ]);

            if(count($request->inputNumSerie) > 0){

                $notas=Nota::find($idNota);
                
                $notaTanque=NotaTanque::where('folio_nota',$notas->folio_nota)->get();
                foreach($notaTanque AS $nt){
                    $estatustanque= Tanque::where('num_serie', $nt->num_serie)->first();
                    $estatustanque->estatus='LLENO-ALMACEN';
                    $estatustanque->save();
                };
                
                NotaTanque::where('folio_nota',$notas->folio_nota)->where('devolucion', false)->delete();
                TanqueHistorial::where('folios','#Nota: '.$notas->folio_nota)->delete();

                $actufolioallnotas=NotaTanque::select('folio_nota')->where('folio_nota',$notas->folio_nota)->get();
                foreach($actufolioallnotas as $act){
                    $cambiarfolio= NotaTanque::where('folio_nota', $act->folio_nota)->first();
                    $cambiarfolio->folio_nota=$request->input('folio_nota');
                    $cambiarfolio->save();
                };

                $notas->fecha = $request->input('fecha');
                $notas->metodo_pago = $request->input('metodo_pago');
                $notas->pago_realizado = $request->input('pago_realizado');
                $notas->num_contrato = $request->input('num_contrato');
                $notas->total = $request->input('inputTotal');

                if($notas->save()){
                    foreach( $request->inputNumSerie AS $series => $g){
                        $notaTanque=new NotaTanque;
                        $notaTanque->folio_nota = $request->input('folio_nota');
                        $notaTanque->num_serie = $request->inputNumSerie[$series];
                        $notaTanque->precio = $request->inputPrecio[$series];
                        // $notaTanque->regulador = $request->inputRegulador[$series];
                        $notaTanque->tapa_tanque = $request->inputTapa[$series];
                        $notaTanque->save();

                        $historytanques=new TanqueHistorial;
                        $historytanques->num_serie = $request->inputNumSerie[$series];
                        $historytanques->estatus = 'ENTREGADO-CLIENTE';
                        $historytanques->folios = '#Nota: '. $request->input('folio_nota');;
                        $historytanques->save();

                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'ENTREGADO-CLIENTE';
                        $tanque->save();
                    }
                    
                }
            }

            return response()->json(['mensaje'=>'Registrado Correctamente']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function destroy($folioNota){
        if($this->slugpermision()){
            $nota= Nota::where('folio_nota', $folioNota)->first();
            $tanqueNota= NotaTanque::where('folio_nota', $nota->folio_nota);
            if($tanqueNota->delete()){
                if($nota->delete()){
                    return response()->json(['mensaje'=>'Eliminado Correctamente']);
                }
            }
            else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }


    public function show($folioNota){
        if($this->slugpermision()){
            $nota=Nota::where('folio_nota', $folioNota)->first();
            
            $notatanque=NotaTanque::
            join('tanques', 'tanques.num_serie', '=', 'nota_tanque.num_serie')
            ->select('tanques.*','nota_tanque.*',)
            ->where('folio_nota', $folioNota)
            ->where('nota_tanque.devolucion', false)
            ->get();

            $data=['nota'=>$nota, 'notatanque'=>$notatanque];
            return $data;
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }

}
