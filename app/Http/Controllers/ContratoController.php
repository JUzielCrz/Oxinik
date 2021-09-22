<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\AsignacionHistorial;
use App\Models\AsignacionNota;
use App\Models\AsignacionNotaDetalle;
use App\Models\AsignacionTanques;
use App\Models\CatalogoGas;
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
        ]);
    }


    public function index($id)
    {
        if($this->slugpermision()){
            $cliente = Cliente::where('id',$id)->first();
            $contratos=Contrato::select('contratos.*')->where('contratos.cliente_id',$id)->get();
            $catalogogas = CatalogoGas::all();
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
                'deposito_garantia' => ['required'],
                
            ]); 

            if($request->input('num_contrato')<1 ||$request->input('deposito_garantia')<1 || $request->input('precio_transporte')<1){
                return response()->json(['alert'=>'alert-danger', 'mensaje'=>'No puedes introducir valores menor a 1']);
            }
            foreach( $request->cilindroscreate AS $negativo => $g){
                if($request->cilindroscreate[$negativo] < 1 || $request->precio_unitariocreate[$negativo] < 1){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'No puedes introducir valores valores menor a 1 en cilindros o P.U.']);
                }
            }

            //valiodacion para que los campos no vengan vacios
            foreach( $request->tipo_gascreate AS $valid => $g){
                if($request->cilindroscreate[$valid] == '' || 
                    $request->tipo_gascreate[$valid] == '' ||
                    $request->materialcreate[$valid] == '' ||
                    $request->tipo_tanquecreate[$valid] == '' ||
                    $request->precio_unitariocreate[$valid] == '' ||
                    $request->unidad_medidacreate[$valid] == ''){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar']);
                }
            }

            foreach( $request->tipo_gascreate AS $search => $g){
                $buscarrepetido=$request->tipo_gascreate[$search]. $request->tipo_tanquecreate[$search]. $request->tipo_contrato.$request->materialcreate[$search];
                foreach( $request->tipo_gascreate AS $rep => $g){
                    if($search != $rep){
                        if($buscarrepetido == $request->tipo_gascreate[$rep]. $request->tipo_tanquecreate[$search]. $request->tipo_contrato.$request->materialcreate[$rep]){
                            return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Asignación de tanques repetidos']);
                        }
                    }
                    

                }
            }
            

            if(Contrato::where('cliente_id', $request->cliente_id)->where('tipo_contrato', $request->tipo_contrato)->first()){
                return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Tipo de contrato repetido']);
            }

            $contratos=new Contrato;
            $contratos->num_contrato = $request->input('num_contrato');
            $contratos->cliente_id = $request->input('cliente_id');
            $contratos->tipo_contrato = $request->tipo_contrato;
            $contratos->precio_transporte = $request->input('precio_transporte');
            $contratos->direccion = $request->input('direccion');
            $contratos->referencia = $request->input('referencia');
            $contratos->link_ubicacion = $request->input('link_ubicacion');
            $contratos->reguladores = $request->input('reguladores');
            $contratos->empresa = $request->input('empresa');
            $contratos->deposito_garantia = $request->input('deposito_garantia');
            $contratos->observaciones= $request->observaciones;

            
            if($contratos->save()){
                
                foreach( $request->tipo_gascreate AS $inci => $g){

                        $newAsignacionTanque= new Asignacion;
                        $newAsignacionTanque->contratos_id=$contratos->id;
                        $newAsignacionTanque->cilindros= $request->cilindroscreate[$inci];
                        $newAsignacionTanque->tipo_gas= $request->tipo_gascreate[$inci];
                        $newAsignacionTanque->tipo_tanque= $request->tipo_tanquecreate[$inci];
                        $newAsignacionTanque->material= $request->materialcreate[$inci];
                        $newAsignacionTanque->precio_unitario= $request->precio_unitariocreate[$inci];
                        $newAsignacionTanque->unidad_medida= $request->unidad_medidacreate[$inci];
                        $newAsignacionTanque->save();          
                }   
                

                // Nota de asignaciones;
                $notaAsig=new AsignacionNota;
                $notaAsig->contrato_id=$contratos->id;
                $notaAsig->fecha=date("Y")."-" . date("m")."-".date("d");
                $notaAsig->incidencia= 'INICIO-CONTRATO';
                $notaAsig->save();

                // $temporal=[]; 
                // array_push($temporal, $request->materialcreate[$inci]); 
                // dump($temporal);
                // return false;

                foreach( $request->tipo_gascreate AS $typeG => $g){
                    $detalleNota=
                    AsignacionNotaDetalle::
                    where('nota_asignacion_id', $notaAsig->id)
                    ->where('tipo_gas', $request->tipo_gascreate[$typeG])
                    ->where('tipo_tanque', $request->tipo_tanquecreate[$typeG])
                    ->where('material', $request->materialcreate[$typeG])
                    ->first();

                    if($detalleNota != null){
                        $detalleNota->cilindros = $detalleNota->cilindros + $request->cilindroscreate[$typeG];
                        $detalleNota->save();
                    }else{
                        $newDetalle= new AsignacionNotaDetalle;
                        $newDetalle->nota_asignacion_id = $notaAsig->id;
                        $newDetalle->cilindros= $request->cilindroscreate[$typeG];
                        $newDetalle->tipo_gas= $request->tipo_gascreate[$typeG];
                        $newDetalle->tipo_tanque= $request->tipo_tanquecreate[$typeG];
                        $newDetalle->unidad_medida= $request->unidad_medidacreate[$typeG];
                        $newDetalle->material= $request->materialcreate[$typeG];
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
            $contratos->link_ubicacion = $request->link_ubicacion;

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
