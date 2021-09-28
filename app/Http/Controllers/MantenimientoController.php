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

    public function data(){
        if($this->slugpermision()){
            $mantenimiento=MantenimientoLLenado::all();
            return DataTables::of(
                $mantenimiento
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show btn-sm" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->rawColumns(['btnShow'])
            ->toJson();
        }
        return view('home');
    }

    public function entrada(){
        if($this->slugpermision()){
            return view('mantenimiento.entrada');
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }
    public function salida(){
        if($this->slugpermision()){
            return view('mantenimiento.salida');
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function registro_save(Request $request){

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
                if($mantenimiento->incidencia=='ENTRADA'){
                    $obse_hystory='Regreso de MANTENIMIENTO. Nota id: '. $mantenimiento->id;
                    $estatus_tanque='LLENO-ALMACEN';
                }else{
                    $obse_hystory='Llevado a MANTENIMIENTO. Nota id: '. $mantenimiento->id;
                    $estatus_tanque='MANTENIMIENTO';
                }
                foreach( $request->inputNumSerie AS $series => $g){
                    $mantenimientoTanque=new MantenimientoTanque;
                    $mantenimientoTanque->num_serie = $request->inputNumSerie[$series];
                    $mantenimientoTanque->mantenimientoLLenado_id = $mantenimiento->id;
                    $mantenimientoTanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = $estatus_tanque;
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $request->inputNumSerie[$series];
                    $historytanques->estatus = $estatus_tanque;
                    $historytanques->observaciones =$obse_hystory;
                    $historytanques->save();
                }
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function show(MantenimientoLLenado $id){
        if($this->slugpermision()){
            $tanques=MantenimientoLLenado::
                join('tanques', 'tanques.num_serie', 'mantenimiento_tanques.num_serie')
                ->where('mantenimientoLLenado_id', $id->id)
                ->get();
            $data = ['mantenimientonota'=>$id, 'tanques' => $tanques];
            return view('mantenimiento.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }
}
