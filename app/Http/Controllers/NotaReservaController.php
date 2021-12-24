<?php

namespace App\Http\Controllers;

use App\Models\NotaReserva;
use App\Models\NotaReservaTanque;
use App\Models\Tanque;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotaReservaController extends Controller
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
        if($this->slug_permiso('nota_reserva')){
            return view('notas.reserva.index');
        }
        return view('home');
    }
    public function data(){
        if($this->slug_permiso('nota_talon')){
            $notas=NotaReserva::
                join('users', 'users.id','=', 'nota_reserva.user_id')
                ->select('nota_reserva.id as nota_id','nota_reserva.*','users.name')
                ->where('user_id', auth()->user()->id);
            return DataTables::of(
                $notas
            )
            ->editColumn('created_at', function ($notas) {
                return $notas->created_at->format('H:i:s A - d/m/Y');
            })
            ->addColumn( 'btnShow', '<button class="btn btn-sm btn-verde btn-show" data-id="{{$nota_id}}" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i> Nota</button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-sm btn-verde btn-delete" data-id="{{$nota_id}}" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>')
            ->rawColumns(['btnShow', 'btnDelete'])
            ->toJson();
        }
        return view('home');
    }

    public function tanques_pendientes(){
        if($this->slug_permiso('nota_reserva')){
            return view('notas.reserva.tanques_pendientes');
        }
        return view('home');
    }
    public function tanques_data(){
        if($this->slug_permiso('nota_talon')){
            $notas=NotaReservaTanque::
                join('nota_reserva', 'nota_reserva.id','=', 'nota_reserva_tanque.nota_id')
                ->join('tanques', 'tanques.num_serie', '=','nota_reserva_tanque.num_serie')
                ->where('tanques.estatus', 'TANQUE-RESERVA');
            return DataTables::of(
                $notas
            )
            ->editColumn('created_at', function ($notas) {
                return $notas->created_at->format('H:i:s A - d/m/Y');
            })
            ->addColumn( 'btnShow', '<button class="btn btn-sm btn-verde btn-show" data-id="{{$nota_id}}" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i> Nota</button>')
            ->rawColumns(['btnShow'])
            ->toJson();
        }
        return view('home');
    }
    public function create(Request $request){   
        if($this->slug_permiso('nota_reserva')){
            $nota=new NotaReserva;
            $nota->user_id =auth()->user()->id;
            $nota->incidencia = $request->incidencia;
            $nota->save();

            if($request->incidencia == 'ENTRADA'){
                $estatus= 'LLENO-ALMACEN';
            }
            if($request->incidencia == 'SALIDA'){
                $estatus= 'TANQUE-RESERVA';
            }
            foreach( $request->inputNumSerie AS $entrada => $g){
                $tanques = new NotaReservaTanque();
                $tanques->num_serie = $request->inputNumSerie[$entrada];
                $tanques->nota_id = $nota->id;
                $tanques->save();

                $cam_estatus=Tanque::where("num_serie", $request->inputNumSerie[$entrada])->first();
                $cam_estatus->estatus=$estatus;
                $cam_estatus->save();
            }
            return response()->json(['alert'=>'success']);
        }
        return view('home');
    }

    public function show(NotaReserva $id){   
        if($this->slug_permiso('nota_reserva')){
            $tanques=Tanque::
            join("nota_reserva_tanque", "tanques.num_serie","=","nota_reserva_tanque.num_serie")
            ->join("catalogo_gases", "catalogo_gases.id","=","tanques.tipo_gas")
            ->where('nota_id',$id->id)->get();
            $data = ['nota'=>$id, 'tanques'=>$tanques];
            return $data;
        }
        return view('home');
    }

    public function show_history($id){
        return 'pass';  
    }
    public function delete(NotaReserva $id){   
        if($this->slug_permiso('nota_reserva')){

            $estatus="";
            if($id->incidencia == "SALIDA"){
                $estatus="LLENO-ALMACEN";
            }else{
                $estatus="TANQUE-RESERVA";
            }

            $tanques = NotaReservaTanque::where("nota_id",$id->id)->get();
            foreach( $tanques as $tanque){
                $cam_estatus=Tanque::where("num_serie", $tanque->num_serie)->first();
                $cam_estatus->estatus=$estatus;
                $cam_estatus->save();
            }

            $id->delete();
            return response()->json(['alert'=>'success']);
        }
        return view('home');
    }
}