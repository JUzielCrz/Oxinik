<?php

namespace App\Http\Controllers;

use App\Models\NotaReserva;
use App\Models\NotaReservaTanque;
use App\Models\Tanque;
use App\Models\Driver;
use App\Models\CatalogoGas;
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
            $drivers=Driver::all();
            return view('notas.reserva.index', compact('drivers'));
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
                return $notas->created_at->format('Y/m/d - H:i:s A');
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
            join('tanques','tanques.num_serie','nota_reserva_tanque.num_serie')
            ->join('nota_reserva','nota_reserva.id','nota_reserva_tanque.nota_id')
            ->select('tanques.num_serie','CONCAT("tanques.tipo_tanque","tanques.fabricante")')
            ->where('tanques.estatus', 'TANQUE-RESERVA');
            // ->addSelect(['gas_name' => CatalogoGas::select('nombre')->whereColumn( 'catalogo_gases.id', 'tanques.tipo_gas')]);
            return DataTables::of(
                $notas
            )
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
            $nota->driver = $request->driver;
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
            $user_name=User::find($id->user_id);
            $tanques=Tanque::
            join("nota_reserva_tanque", "tanques.num_serie","=","nota_reserva_tanque.num_serie")
            ->join("catalogo_gases", "catalogo_gases.id","=","tanques.tipo_gas")
            ->where('nota_id',$id->id)->get();
            $data = ['nota'=>$id, 'tanques'=>$tanques, 'user_name'=>$user_name->name];
            return $data;
        }
        return view('home');
    }

    public function show_history($id){
        $nota=NotaReserva::find($id);
        $tanques=NotaReservaTanque::
        join('tanques','tanques.num_serie','=','nota_reserva_tanque.num_serie')
        ->where('nota_id',$id)->get();
        $usuario=User::where('id',$nota->user_id)->first();
        $data = ['nota'=>$nota, 'tanques'=>$tanques, 'usuario'=>$usuario];
        return view('notas.reserva.show_history', $data);
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
