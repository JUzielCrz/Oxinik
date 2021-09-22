<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TanqueController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('tanques');
    }

    protected function validator(array $data,$id){
        return Validator::make($data, [
            'num_serie' => ['required', 'string','max:255', Rule::unique('tanques')->ignore($id, 'id')],
            'ph' => ['required', 'string', 'max:255'],
            'capacidad' => ['required', 'string', 'max:255'],
            'material' => ['required', 'string', 'max:255'],
            'fabricante' => ['required', 'string', 'max:255'],
            'tipo_gas' =>  ['required', 'string', 'max:255'],
            'tipo_tanque' =>  ['required', 'string', 'max:255'],
        ]);
    }

    public function index()
    {
        if($this->slugpermision()){
            $catalogo = CatalogoGas::pluck('nombre','id');
            $data= ['catalogo'=>$catalogo];
            return view('tanques.index', $data);
        }
        return view('home');
    }

    public function tanques_data(){
        if($this->slugpermision()){
            $tanques=Tanque::
            select('tanques.*')
            ->where('estatus',"!=","BAJA-TANQUE");
            return DataTables::of(
                $tanques
            )                                                               
            ->addColumn( 'btnHistory', '<a class="btn btn-sm btn-grisclaro btn-xs" href="{{route(\'tanques.history\', $id)}}" title="Historial"><span class="fas fa-history"></span></a>')
            ->addColumn( 'btnShow', '<button class="btn btn-sm btn-grisclaro btn-show-modal btn-xs" data-id="{{$id}}" title="Información"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-grisclaro btn-edit-modal btn-xs" data-id="{{$id}}" title="Editar"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnBaja', '<button class="btn btn-sm btn-grisclaro btn-delete-modal btn-xs" data-id="{{$id}}" title="Baja"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnHistory','btnShow','btnEdit','btnBaja'])
            ->toJson();
        }
        return view('home');
    }


    public function create(Request $request)
    {
        if($this->slugpermision()){
            $request->validate([
                'num_serie' => ['required', 'string', 'max:255','unique:tanques,num_serie'],
                'ph' => ['required', 'string', 'max:255'],
                'capacidad' => ['required', 'string', 'max:255'],
                'material' => ['required', 'string', 'max:255'],
                'fabricante' => ['required', 'string', 'max:255'],
                'tipo_gas' =>  ['required', 'string', 'max:255'],
                'estatus' =>  ['required', 'string', 'max:255'],
                'tipo_tanque' =>  ['required', 'string', 'max:255'],
            ]);
            $tanques=new Tanque;
            $tanques->num_serie = $request->input('num_serie');
            $tanques->ph = $request->input('ph');
            $tanques->capacidad = $request->input('capacidad');
            $tanques->material = $request->input('material');
            $tanques->fabricante = $request->input('fabricante');
            $tanques->tipo_gas = $request->input('tipo_gas');
            $tanques->estatus = $request->input('estatus');
            $tanques->tipo_tanque = $request->input('tipo_tanque');
            

            if($tanques->save()){
                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $request->input('num_serie');
                $historytanques->estatus = $request->input('estatus');
                $historytanques->observaciones ='Registro del tanque';
                $historytanques->save();
                return response()->json(['mensaje'=>' Registrado Correctamente']);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show( Tanque $id){
        if($this->slugpermision()){
            return $id;
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show_numserie($num_serie){
        if($this->slugpermision()){
            $tanque=Tanque::where('num_serie',$num_serie)->first();
            return $tanque;
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function update(Request $request, $id)
    {
        if($this->slugpermision()){
            $this->validator($request->all(),$id)->validate();

            $tanques=  Tanque::find($id);
            $tanques->num_serie = $request->input('num_serie');
            $tanques->ph = $request->input('ph');
            $tanques->capacidad = $request->input('capacidad');
            $tanques->material = $request->input('material');
            $tanques->fabricante = $request->input('fabricante');
            $tanques->tipo_gas = $request->input('tipo_gas');
            $tanques->estatus = $request->input('estatus');
            $tanques->tipo_tanque = $request->input('tipo_tanque');

            if($tanques->save()){
                $historytanques=new TanqueHistorial;
                $historytanques->num_serie = $request->input('num_serie');
                $historytanques->estatus = $request->input('estatus');
                $historytanques->observaciones ='Edición de los datos del tanque';
                $historytanques->save();
                return response()->json(['mensaje'=>' Editado Correctamente']);
            }
            return response()->json(['mensaje'=>'No Editado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function baja_tanque(Tanque $id){
        if($this->slugpermision()){
            $id->estatus = "BAJA-TANQUE";

            if($id->save()){
                $historytanques=new TanqueHistorial;
            $historytanques->num_serie = $id->num_serie;
            $historytanques->estatus = $id->estatus;
            $historytanques->observaciones ='Tanque dado de baja';
            $historytanques->save();
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function restablecer_tanque(Tanque $id){
        if($this->slugpermision()){
            $id->estatus = "VACIO-ALMACEN";

            if($id->save()){
                $historytanques=new TanqueHistorial;
            $historytanques->num_serie = $id->num_serie;
            $historytanques->estatus = $id->estatus;
            $historytanques->observaciones ='Tanque restablecido como vacio en almacen';
            $historytanques->save();
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }




    //////// Historial de tanques 

    public function history(Tanque $id){
        if($this->slugpermision()){
            $data=['tanque'=>$id];
            return view('tanques.history', $data);
        }
        return view('home');
    }

    public function history_data($serietanque){
        if($this->slugpermision()){
            $tanques=TanqueHistorial::
            select('tanque_historial.*')->where('num_serie',$serietanque);
            return DataTables::of(
                $tanques
            )
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('H:i:s A - d/m/Y');
            })
            ->toJson();
        }
        return view('home');
    }


    public function lista_bajas()
    {
        if($this->slugpermision()){
            return view('tanques.lista_bajas');
        }
        return view('home');
    }

    public function lista_bajas_data(){
        if($this->slugpermision()){
            $tanques=Tanque::
            select('tanques.*')
            ->where('estatus',"BAJA-TANQUE");
            return DataTables::of(
                $tanques
            )             
            ->addColumn( 'btnRestablecer', '<button class="btn btn-sm btn-grisclaro btn-delete-modal btn-xs" data-id="{{$id}}" title="Restablecer"><i class="fas fa-trash-restore-alt"></i></button>')
            ->addColumn( 'btnHistory', '<a class="btn btn-sm btn-grisclaro btn-xs" href="{{route(\'tanques.history\', $id)}}" title="Historial"><span class="fas fa-history"></span></a>')
            ->rawColumns(['btnHistory','btnRestablecer'])
            ->toJson();
        }
        return view('home');
    }
}