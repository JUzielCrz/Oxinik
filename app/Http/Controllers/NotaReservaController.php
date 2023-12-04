<?php

namespace App\Http\Controllers;
use App\Models\DatosEmpresa;
use App\Models\NotaReserva;
use App\Models\NotaReservaTanque;
use App\Models\Tanque;
use App\Models\Driver;
use App\Models\Car;
use App\Models\CatalogoGas;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

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
                ->where('user_id', auth()->user()->id)->orderBy('nota_id','DESC')->limit(200);
            return DataTables::of(
                $notas
            )
            ->editColumn('created_at', function ($notas) {
                return $notas->created_at->format('Y/m/d - H:i:s A');
            })
            ->addColumn( 'buttons', '<button class="btn btn-sm btn-verde btn-show mx-1" data-id="{{$nota_id}}" data-toggle="tooltip" data-placement="right" title="Nota"><i class="fas fa-sticky-note"></i></button>'.
                '<button class="btn btn-sm btn-verde btn-delete mx-1" data-toggle="tooltip" data-placement="right" title="Eliminar"><i class="fas fa-trash-alt"></i></button>'.
                '<a class="btn btn-sm btn-verde mx-1" target="_blank" href="{{route(\'notas.reserva.pdf\', $nota_id)}}" title="PDF"><i class="fas fa-file-pdf"></i></a>'
                )
            ->rawColumns(['buttons'])
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
            ->select("tanques.*","nota_reserva.id as nota_id", "nota_reserva.car", "nota_reserva.driver")
            ->addSelect(['gas_name' => CatalogoGas::select('nombre')->whereColumn( 'catalogo_gases.id', 'tanques.tipo_gas')])
            ->where('tanques.estatus', 'TANQUE-RESERVA');
            return DataTables::of(
                $notas
            )
            ->addColumn( 'buttons', '<button class="btn btn-sm btn-verde btn-show mx-1" data-id="{{$nota_id}}" data-toggle="tooltip" data-placement="right" title="Nota"><i class="fas fa-sticky-note"></i></button>'.
                '<a class="btn btn-sm btn-verde mx-1" target="_blank" href="{{route(\'notas.reserva.pdf\', $nota_id)}}" title="PDF"><i class="fas fa-file-pdf"></i></a>'
                )
            ->rawColumns(['buttons'])
            ->toJson();
        }
        return view('home');
    }

    public function create(Request $request){
        $drivers=Driver::all();
        $cars=Car::all();
        return view('notas.reserva.create', compact('drivers','cars'));
    }

    public function save(Request $request){   
        // dd($request->all());
        if($this->slug_permiso('nota_reserva')){
            $nota=new NotaReserva;
            $nota->user_id =auth()->user()->id;
            $nota->incidencia = $request->incidencia;
            $nota->driver = $request->driver;
            $nota->car = $request->car;
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

    public function pdf($id){
        $nota=NotaReserva::find($id);
        $tanques=NotaReservaTanque::
        join('tanques', 'tanques.num_serie','=','nota_reserva_tanque.num_serie' )
        ->where('nota_id', $nota->id)->get();
        $empresa=DatosEmpresa::find(1);

        $data=['nota'=>$nota,'tanques'=>$tanques,'empresa'=>$empresa];
        $pdf = PDF::loadView('notas.reserva.pdf', $data);
    
        return $pdf->stream('nota_reserva_'.$nota->id.'.pdf');
        return $pdf->dowload('name.pdf');
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
