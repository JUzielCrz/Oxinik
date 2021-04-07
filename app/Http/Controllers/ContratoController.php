<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\AsignacionHistorial;
use App\Models\AsignacionNota;
use App\Models\AsignacionNotaDetalle;
use App\Models\AsignacionTanques;
use App\Models\CatalogoGases;
use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
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
    
    protected function validatorupdate(array $data,$id)
    {
        return Validator::make($data, [
            'num_contrato' => ['required','max:50', Rule::unique('contratos')->ignore($id, 'id')],
            'cliente_id' => ['required'],
            'tipo_contrato' => ['required', 'string', 'max:255'],
            'precio_transporte' => ['required', 'string', 'max:255'],
        ]);
    }


    public function index($id)
    {
        if($this->slugpermision()){
            $cliente = Cliente::where('id',$id)->first();
            $contratos=Contrato::select('contratos.*')->where('contratos.cliente_id',$id)->get();
            $catalogogas = CatalogoGases::all();
            $data = ['cliente'=> $cliente, 'contratos'=>$contratos, 'catalogogas'=>$catalogogas];
            return view('contratos.index', $data);
        }
        return view('home');
    }


    public function create(Request $request)
    {
        if($this->slugpermision()){
            $request->validate([
                'num_contrato' => ['required', 'string', 'max:255', 'unique:contratos,num_contrato'],
                'cliente_id' => ['required'],
                'tipo_contrato' => ['required', 'string', 'max:255'],
                'precio_transporte' => ['required', 'string', 'max:255'],
            ]);

            //valiodacion para que los campos no vengan vacios
            foreach( $request->tipo_gascreate AS $inci => $g){
                if($request->cantidadtanquescreate[$inci] == '' || $request->tipo_gascreate[$inci] == ''){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar']);
                }
            }

            $contratos=new Contrato;
            $contratos->num_contrato = $request->input('num_contrato');
            $contratos->cliente_id = $request->input('cliente_id');
            $contratos->tipo_contrato = $request->input('tipo_contrato');
            $contratos->precio_transporte = $request->input('precio_transporte');
            $contratos->direccion = $request->input('direccion');
            $contratos->referencia = $request->input('referencia');

            if($contratos->save()){
                

                foreach( $request->tipo_gascreate AS $inci => $g){
                    $asignaciontanque=Asignacion::where('contratos_id', $contratos->id)->where('tipo_gas', $request->tipo_gascreate[$inci])->first();
                    if($asignaciontanque != null){
                        $asignaciontanque->cantidad = $asignaciontanque->cantidad + $request->cantidadtanquescreate[$inci];
                        $asignaciontanque->save();
                    }else{
                        $newAsignacionTanque= new Asignacion;
                        $newAsignacionTanque->contratos_id=$contratos->id;
                        $newAsignacionTanque->cantidad= $request->cantidadtanquescreate[$inci];
                        $newAsignacionTanque->tipo_gas= $request->tipo_gascreate[$inci];
                        $newAsignacionTanque->save();          
                    }
                }   

                // Nota de asignaciones;
                $notaAsig=new AsignacionNota;
                $notaAsig->contrato_id=$contratos->id;
                $notaAsig->fecha=date("Y")."-" . date("m")."-".date("d");
                $notaAsig->incidencia= 'INICIO-CONTRATO';
                $notaAsig->save();

                foreach( $request->tipo_gascreate AS $typeG => $g){
                    $detalleNota=AsignacionNotaDetalle::where('nota_asignacion_id', $notaAsig->id)->where('tipo_gas', $request->tipo_gascreate[$typeG])->first();
                    if($detalleNota != null){
                        $detalleNota->cantidad = $detalleNota->cantidad + $request->cantidadtanquescreate[$typeG];
                        $detalleNota->save();
                    }else{
                        $newDetalle= new AsignacionNotaDetalle;
                        $newDetalle->nota_asignacion_id = $notaAsig->id;
                        $newDetalle->cantidad= $request->cantidadtanquescreate[$typeG];
                        $newDetalle->tipo_gas= $request->tipo_gascreate[$typeG];
                        
                        $newDetalle->save(); 
                    }         
                }

                return response()->json(['mensaje'=>'Registrado Correctamente', 'contratos'=>$contratos, 'notaAsig_id'=>$notaAsig->id]);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show($contrato_id)
    {
        if($this->slugpermision()){
            $contrato=Contrato::where('id',$contrato_id)->first();
            // $asignacion=Asignacion::where('num_contrato', $num_contrato)->first();
            
            // $asigTanques=AsignacionTanques::
            // join('catalogo_gases','catalogo_gases.id','=','asignacion_tanques.tipo_gas')
            // ->where('asignacion_id',$asignacion->id)->get();

            $data=['contratos'=>$contrato];
            return $data;
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function update(Request $request, $id)
    {
        if($this->slugpermision()){

            $this->validatorupdate($request->all(),$id)->validate();


            $contratos = Contrato::find($id);
            $contratos->num_contrato = $request->num_contrato;
            $contratos->cliente_id = $request->cliente_id;
            $contratos->tipo_contrato = $request->tipo_contrato;;
            $contratos->precio_transporte = $request->precio_transporte;
            $contratos->direccion = $request->direccion;
            $contratos->referencia = $request->referencia;

            if($contratos->save()){
                    return response()->json(['mensaje'=>'Editado Correctamente', 'contratos'=>$contratos]);
            }
            return response()->json(['mensaje'=>'Error, Verifica tus datos']);

        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function destroy(Contrato $id)
    {
        if($this->slugpermision()){
            if($id->delete()){
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }
            return response()->json(['mensaje'=>'Error al Eliminar']);
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);

    }

    

}
