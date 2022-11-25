<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\AsignacionNota;
use App\Models\AsignacionNotaDetalle;
use App\Models\CatalogoGas;
use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ContratoController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }
    
    protected function validatorupdate(array $data,$id){
        return Validator::make($data, [
            'cliente_id' => ['required'],
            'tipo_contrato' => ['required', 'string', 'max:255'],
        ]);
    }

    public function index($id){
        if($this->slug_permiso('contrato_show')){
            $cliente = Cliente::where('id',$id)->first();
            $contratos=Contrato::select('contratos.*')->where('contratos.cliente_id',$id)->get();
            $catalogogas = CatalogoGas::all();
            $data = ['cliente'=> $cliente, 'contratos'=>$contratos, 'catalogogas'=>$catalogogas];
            return view('contratos.index', $data);
        }
        return view('home');
    }

    public function create(Request $request){


        if($this->slug_permiso('contrato_create')){
            $request->validate([
                'cliente_id' => ['required'],
                'tipo_contrato' => ['required', 'string', 'max:255'],
                
            ]); 

            if($request->input('deposito_garantia')<0 || $request->input('precio_transporte')<0){
                return response()->json(['alert'=>'alert-danger', 'mensaje'=>'No puedes introducir valores menor a 0']);
            }
            foreach( $request->cilindroscreate AS $negativo => $g){
                if($request->cilindroscreate[$negativo] < 1 || $request->precio_unitariocreate[$negativo] < 1|| $request->capacidadcreate[$negativo] < 1){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'No puedes introducir valores valores menor a 1 en asignacion de tanques']);
                }
            }

            //valiodacion para que los campos no vengan vacios
            foreach( $request->tipo_gascreate AS $valid => $g){
                if($request->cilindroscreate[$valid] == '' || 
                    $request->tipo_gascreate[$valid] == '' ||
                    $request->materialcreate[$valid] == '' ||
                    $request->tipo_tanquecreate[$valid] == '' ||
                    $request->precio_unitariocreate[$valid] == '' ||
                    $request->deposito_garantiacreate[$valid] == '' ||
                    $request->unidad_medidacreate[$valid] == ''){
                    return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Faltan campos por rellenar']);
                }
            }

            foreach( $request->tipo_gascreate AS $search => $g){
                $buscarrepetido=$request->tipo_gascreate[$search]. $request->tipo_tanquecreate[$search]. $request->tipo_contrato.$request->materialcreate[$search].$request->capacidadcreate[$search].$request->unidad_medidacreate[$search];
                foreach( $request->tipo_gascreate AS $rep => $g){
                    if($search != $rep){
                        if($buscarrepetido == $request->tipo_gascreate[$rep]. $request->tipo_tanquecreate[$search]. $request->tipo_contrato.$request->materialcreate[$rep].$request->capacidadcreate[$rep].$request->unidad_medidacreate[$rep]){
                            return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Asignación de tanques repetidos']);
                        }
                    }
                    

                }
            }
            

            if(Contrato::where('cliente_id', $request->cliente_id)->where('tipo_contrato', $request->tipo_contrato)->first()){
                return response()->json(['alert'=>'alert-danger', 'mensaje'=>'Tipo de contrato repetido']);
            }

            $contratos=new Contrato;
            $contratos->cliente_id = $request->input('cliente_id');
            $contratos->tipo_contrato = $request->tipo_contrato;
            $contratos->precio_renta = $request->precio_renta;
            $contratos->frecuency = $request->frecuency;
            $contratos->nombre_comercial = $request->nombre_comercial;
            $contratos->modelo_regulador = $request->modelo_regulador;
            $contratos->precio_transporte = $request->input('precio_transporte');
            $contratos->direccion = $request->input('direccion');
            $contratos->referencia = $request->input('referencia');
            $contratos->calle1 = $request->calle1;
            $contratos->calle2 = $request->calle2;
            $contratos->link_ubicacion = $request->input('link_ubicacion');
            $contratos->reguladores = $request->input('reguladores');
            $contratos->observaciones= $request->observaciones;
            $contratos->nombre_solidaria= $request->nombre_solidaria;
            $contratos->telefono_solidaria= $request->telefono_solidaria;
            $contratos->email_solidaria= $request->email_solidaria;
            $contratos->direccion_solidaria= $request->direccion_solidaria;

            
            if($contratos->save()){
                
                foreach( $request->tipo_gascreate AS $inci => $g){

                        $newAsignacionTanque= new Asignacion;
                        $newAsignacionTanque->contratos_id=$contratos->id;
                        $newAsignacionTanque->cilindros= $request->cilindroscreate[$inci];
                        $newAsignacionTanque->tipo_gas= $request->tipo_gascreate[$inci];
                        $newAsignacionTanque->tipo_tanque= $request->tipo_tanquecreate[$inci];
                        $newAsignacionTanque->material= $request->materialcreate[$inci];
                        $newAsignacionTanque->precio_unitario= $request->precio_unitariocreate[$inci];
                        $newAsignacionTanque->capacidad= $request->capacidadcreate[$inci];
                        $newAsignacionTanque->unidad_medida= $request->unidad_medidacreate[$inci];
                        $newAsignacionTanque->save();          
                }   
                

                // Nota de asignaciones;
                $notaAsig=new AsignacionNota;
                $notaAsig->contrato_id=$contratos->id;
                $notaAsig->fecha=date("Y")."-" . date("m")."-".date("d");
                $notaAsig->incidencia= 'INICIO-CONTRATO';
                $notaAsig->user_id= auth()->user()->id;
                $notaAsig->save();

                foreach( $request->tipo_gascreate AS $typeG => $g){
                    $detalleNota=
                    AsignacionNotaDetalle::
                    where('nota_asignacion_id', $notaAsig->id)
                    ->where('tipo_gas', $request->tipo_gascreate[$typeG])
                    ->where('tipo_tanque', $request->tipo_tanquecreate[$typeG])
                    ->where('material', $request->materialcreate[$typeG])
                    ->where('capacidad', $request->capacidadcreate[$typeG])
                    ->where('unidad_medida', $request->unidad_medidacreate[$typeG])
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
                        $newDetalle->capacidad= $request->capacidadcreate[$typeG];
                        $newDetalle->unidad_medida= $request->unidad_medidacreate[$typeG];
                        $newDetalle->material= $request->materialcreate[$typeG];
                        $newDetalle->deposito_garantia= $request->deposito_garantiacreate[$typeG];
                        $newDetalle->save(); 
                    }         
                }

                return response()->json(['mensaje'=>'Registrado Correctamente', 'contratos'=>$contratos, 'notaAsig_id'=>$notaAsig->id]);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show($contrato_id){
        if($this->slug_permiso('contrato_show')){
            $contrato=Contrato::where('id',$contrato_id)->first();

            $data=['contratos'=>$contrato];
            return $data;
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function envio_show($contrato_id){
        $contrato=Contrato::select('precio_transporte', 'precio_transporte', 'direccion', 'referencia')->where('id',$contrato_id)->first();

        $data=['contratos'=>$contrato];
        return $data;
    }

    public function update(Request $request, $id){
        if($this->slug_permiso('contrato_update')){

            $this->validatorupdate($request->all(),$id)->validate();


            $contratos = Contrato::find($id);
            $contratos->cliente_id = $request->cliente_id;
            $contratos->tipo_contrato = $request->tipo_contrato;
            $contratos->nombre_comercial = $request->nombre_comercial;
            $contratos->reguladores = $request->reguladores;
            $contratos->modelo_regulador = $request->modelo_regulador;
            $contratos->precio_transporte = $request->precio_transporte;
            $contratos->direccion = $request->direccion;
            $contratos->referencia = $request->referencia;
            $contratos->calle1 = $request->calle1;
            $contratos->calle2 = $request->calle2;
            $contratos->link_ubicacion = $request->link_ubicacion;
            $contratos->nombre_solidaria= $request->nombre_solidaria;
            $contratos->telefono_solidaria= $request->telefono_solidaria;
            $contratos->email_solidaria= $request->email_solidaria;
            $contratos->direccion_solidaria= $request->direccion_solidaria;

            if($contratos->save()){
                    return response()->json(['mensaje'=>'Editado Correctamente', 'contratos'=>$contratos]);
            }
            return response()->json(['mensaje'=>'Error, Verifica tus datos']);

        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function destroy(Contrato $id){
        if($this->slug_permiso('contrato_delete')){
            $id->delete();
            return response()->json(['mensaje'=>'Eliminado Correctamente']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function contratos_listar(){
        if($this->slug_permiso('contrato_show')){
            return view('contratos.listar');
        }
        return view('home');
    }

    public function listar_data(Request $request){
        if($this->slug_permiso('contrato_show')){
            if($request->tipo_contrato == "ALL"){
                $contrato=Contrato::
                join('clientes','clientes.id',"=", 'contratos.cliente_id')
                ->select('contratos.id as contrato_id','contratos.direccion', 'contratos.cliente_id', 'tipo_contrato')
                ->where('clientes.estatus',$request->estatus);
            }else{
                $contrato=Contrato::
                join('clientes','clientes.id',"=", 'contratos.cliente_id')
                ->select('contratos.id as contrato_id','contratos.direccion', 'contratos.cliente_id', 'tipo_contrato')
                ->where('clientes.estatus',$request->estatus)
                ->where('contratos.tipo_contrato', $request->tipo_contrato);
            }
            
            return DataTables::of(
                $contrato
            )
            ->editColumn('cliente', function ($contrato) {
                $cliente = 
                Cliente::select('nombre','apPaterno','apMaterno')
                ->where('id', $contrato->cliente_id)
                ->first();
                return $cliente->nombre." ".$cliente->apPaterno." ".$cliente->apMaterno;
            })
            ->addColumn( 'btnShow', '<a class="btn btn-sm btn-verde btn-xs" href="{{route(\'contrato.index\', $cliente_id)}}" title="Información"><span class="far fa-eye"></span></a>')
            ->rawColumns(['btnShow'])
            ->toJson();
        }
        return view('home');
    }

}
