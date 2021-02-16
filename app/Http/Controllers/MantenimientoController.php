<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoLLenado;
use App\Models\MantenimientoTanque;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\User;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MantenimientoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('mantenimiento');
    }


    public function index(){
        if($this->slugpermision()){
            return view('mantenimiento.index');
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function datatables(){
        if($this->slugpermision()){
            $mantenimiento=MantenimientoLLenado::
            select('mantenimiento_llenado.*');
            return DataTables::of(
                $mantenimiento
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
            return view('mantenimiento.create');
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

            $mantenimiento=new MantenimientoLLenado;
            $mantenimiento->cantidad= $request->cantidad;
            $mantenimiento->fecha= $fechaactual;
            $mantenimiento->incidencia= $request->incidencia;

            if($mantenimiento->save()){
                foreach( $request->inputNumSerie AS $series => $g){
                    $MantenimientoTanque=new MantenimientoTanque;
                    $MantenimientoTanque->num_serie = $request->inputNumSerie[$series];
                    $MantenimientoTanque->MantenimientoLLenado_id = $mantenimiento->id;
                    $MantenimientoTanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = 'MANTENIMIENTO';
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $request->inputNumSerie[$series];
                    $historytanques->estatus = 'MANTENIMIENTO';
                    $historytanques->folios ='#mantenimiento: '. $mantenimiento->id;
                    $historytanques->save();
                }
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }


    public function edit(MantenimientoLLenado $id){

        if($this->slugpermision()){

            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            if( $fechaactual == $id->fecha){
                $tanques=MantenimientoTanque::join('tanques', 'tanques.num_serie', 'mantenimiento_tanques.num_serie')->where('MantenimientoLLenado_id', $id->id)->get();
                $data = ['mantenimientonota'=>$id, 'tanques' => $tanques];
                return view('mantenimiento.edit', $data);
            }
            return back()->with('alertas', 'Solo puedes editar notas en el mismo día que fuerón creadas');
        }

        return response()->json(['mensaje'=>'Sin permisos']);
        
    }
    
    public function update(Request $request){
        if($this->slugpermision()){
            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            $notamantenimiento=MantenimientoLLenado::find($request->idMantenimientoNota);
            if( $fechaactual == $notamantenimiento->fecha){
                $notamantenimiento->incidencia = $request->incidencia;
                $notamantenimiento->cantidad = $request->cantidad;
                if($notamantenimiento->save()){
                    foreach( $request->inputNumSerie AS $series => $g){
                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'VACIO-ALMACEN';
                        $tanque->save();
                    }

                    MantenimientoTanque::where('MantenimientoLLenado_id',$notamantenimiento->id)->delete();
                    
                    foreach( $request->inputNumSerie AS $series => $g){
                        $MantenimientoTanque=new MantenimientoTanque;
                        $MantenimientoTanque->num_serie = $request->inputNumSerie[$series];
                        $MantenimientoTanque->MantenimientoLLenado_id = $notamantenimiento->id;
                        $MantenimientoTanque->save();

                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'MANTENIMIENTO';
                        $tanque->save();

                        $historytanques=new TanqueHistorial;
                        $historytanques->num_serie = $request->inputNumSerie[$series];
                        $historytanques->estatus = 'MANTENIMIENTO';
                        $historytanques->save();
                    }
                }
                return response()->json(['mensaje'=>'Actualizado correctamente',  'alert'=>'alert-primary']);
            }

            return response()->json(['mensaje'=>'Solo puedes editar notas en el mismo día que fuerón creadas', 'alert'=>'alert-danger']);
            
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function delete(MantenimientoLLenado $id){
        if($this->slugpermision()){
            $fechaactual=date("Y")."-" . date("m")."-".date("d");
            if( $fechaactual == $id->fecha){
                $tanques= MantenimientoTanque::where('MantenimientoLLenado_id', $id->id)->get();
                
                foreach( $tanques AS $tanq){
                    $tanque=Tanque::where('num_serie',$tanq->num_serie)->first();
                    $tanque->estatus = 'VACIO-ALMACEN';
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $tanq->num_serie;
                    $historytanques->estatus = 'VACIO-ALMACEN';
                    $historytanques->save();
                }

                MantenimientoTanque::where('MantenimientoLLenado_id', $id->id)->delete();

                $id->delete();

                return response()->json(['mensaje'=>'Eliminado correctamente', 'alert'=>'alert-primary']);
            }
            return response()->json(['mensaje'=>'Solo puedes eliminar notas en el mismo día que fuerón creadas', 'alert'=>'alert-danger']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    
}
