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

    public function data(){
        if($this->slugpermision()){
            $infra=InfraLLenado::all();
            return DataTables::of(
                $infra
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show btn-sm" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            // ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            // ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnContrato','btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }

    public function entrada(){
        if($this->slugpermision()){
            return view('infra.entrada');
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }
    public function salida(){
        if($this->slugpermision()){
            return view('infra.salida');
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

            $infra=new InfraLLenado;
            $infra->cantidad= $request->cantidad;
            $infra->fecha= $fechaactual;
            $infra->incidencia= $request->incidencia;

            if($infra->save()){
                if($infra->incidencia=='ENTRADA'){
                    $obse_hystory='Regreso de INFRA. Nota id: '. $infra->id;
                    $estatus_tanque='LLENO-ALMACEN';
                }else{
                    $obse_hystory='Llevado a INFRA. Nota id: '. $infra->id;
                    $estatus_tanque='INFRA';
                }
                foreach( $request->inputNumSerie AS $series => $g){
                    $infratanque=new InfraTanque;
                    $infratanque->num_serie = $request->inputNumSerie[$series];
                    $infratanque->infrallenado_id = $infra->id;
                    $infratanque->save();

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

    public function show(InfraLLenado $id){
        if($this->slugpermision()){
            $tanques=InfraTanque::
                join('tanques', 'tanques.num_serie', 'infra_tanques.num_serie')
                ->where('infrallenado_id', $id->id)
                ->get();
            $data = ['infranota'=>$id, 'tanques' => $tanques];
            return view('infra.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }

}
