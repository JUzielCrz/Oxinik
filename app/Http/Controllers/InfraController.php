<?php

namespace App\Http\Controllers;

use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\User;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InfraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('infra');
    }


    public function index(){
        if($this->slugpermision()){
            return view('infra.index');
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function datatables(){
        if($this->slugpermision()){
            $infra=InfraLLenado::
            select('infra_llenado.*');
            return DataTables::of(
                $infra
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnContrato','btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }

    public function create(){
        if($this->slugpermision()){
            return view('infra.create');
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }
    
    public function buscartanque($serie){
        

        if(Tanque::where('num_serie',$serie)->where('estatus', 'VACIO-ALMACEN')->first()){
            $buscar=Tanque::where('num_serie',$serie)->where('estatus', 'VACIO-ALMACEN')->first();
            return response()->json(['tanque'=>$buscar]);
        }
        return response()->json(['tanque'=>'NO ENCONTRADO']);
    }

    

    public function savenote(Request $request){

        if($this->slugpermision()){
            $request->validate([
                // 'fecha' => ['required'],
                'cantidad' => ['required', 'int'],
                'incidencia' => ['required', 'string', 'max:255'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

            $infra=new InfraLLenado;
            $infra->cantidad= $request->cantidad;
            $infra->fecha= $fechaactual;
            $infra->incidencia= $request->incidencia;

            if($infra->save()){
                foreach( $request->inputNumSerie AS $series => $g){
                    $infratanque=new InfraTanque;
                    $infratanque->num_serie = $request->inputNumSerie[$series];
                    $infratanque->infrallenado_id = $infra->id;
                    $infratanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = 'INFRA';
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $request->inputNumSerie[$series];
                    $historytanques->estatus = 'INFRA';
                    $historytanques->folios ='#Infra: '. $infra->id;
                    $historytanques->save();
                }
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }


    public function edit(InfraLLenado $id){

        if($this->slugpermision()){

            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            if( $fechaactual == $id->fecha){
                $tanques=InfraTanque::join('tanques', 'tanques.num_serie', 'infra_tanques.num_serie')->where('infrallenado_id', $id->id)->get();
                $data = ['infranota'=>$id, 'tanques' => $tanques];
                return view('infra.edit', $data);
            }
            return back()->with('alertas', 'Solo puedes editar notas en el mismo día que fuerón creadas');
        }

        return response()->json(['mensaje'=>'Sin permisos']);
        
    }
    
    public function update(Request $request){
        if($this->slugpermision()){
            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            $notainfra=InfraLLenado::find($request->idInfraNota);
            if( $fechaactual == $notainfra->fecha){
                $notainfra->incidencia = $request->incidencia;
                $notainfra->cantidad = $request->cantidad;
                if($notainfra->save()){
                    foreach( $request->inputNumSerie AS $series => $g){
                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'VACIO-ALMACEN';
                        $tanque->save();
                    }

                    InfraTanque::where('infrallenado_id',$notainfra->id)->delete();
                    
                    foreach( $request->inputNumSerie AS $series => $g){
                        $infratanque=new InfraTanque;
                        $infratanque->num_serie = $request->inputNumSerie[$series];
                        $infratanque->infrallenado_id = $notainfra->id;
                        $infratanque->save();

                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'INFRA';
                        $tanque->save();

                        $historytanques=new TanqueHistorial;
                        $historytanques->num_serie = $request->inputNumSerie[$series];
                        $historytanques->estatus = 'INFRA';
                        $historytanques->save();
                    }
                }
                return response()->json(['mensaje'=>'Actualizado correctamente',  'alert'=>'alert-primary']);
            }

            return response()->json(['mensaje'=>'Solo puedes editar notas en el mismo día que fuerón creadas', 'alert'=>'alert-danger']);
            
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function delete(InfraLLenado $id){
        if($this->slugpermision()){
            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            if( $fechaactual == $id->fecha){
                $tanques= InfraTanque::where('infrallenado_id', $id->id)->get();
                
                foreach( $tanques AS $tanq){
                    $tanque=Tanque::where('num_serie',$tanq->num_serie)->first();
                    $tanque->estatus = 'VACIO-ALMACEN';
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $tanq->num_serie;
                    $historytanques->estatus = 'VACIO-ALMACEN';
                    $historytanques->save();
                }

                InfraTanque::where('infrallenado_id', $id->id)->delete();

                $id->delete();

                return response()->json(['mensaje'=>'Eliminado correctamente', 'alert'=>'alert-primary']);
            }
            return response()->json(['mensaje'=>'Solo puedes eliminar notas en el mismo día que fuerón creadas', 'alert'=>'alert-danger']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    
}
