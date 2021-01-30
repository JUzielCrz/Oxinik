<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TanqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('tanques');
    }

    protected function validator(array $data,$id)
    {
        return Validator::make($data, [
            'num_serie' => ['required', 'string','max:255', Rule::unique('tanques')->ignore($id, 'id')],
            'ph' => ['required', 'string', 'max:255'],
            'capacidad' => ['required', 'string', 'max:255'],
            'material' => ['required', 'string', 'max:255'],
            'fabricante' => ['required', 'string', 'max:255'],
            'tipo_gas' =>  ['required', 'string', 'max:255'],
        ]);
    }

    public function index()
    {
        if($this->slugpermision()){
            return view('tanques.index');
        }
        return view('home');
    }

    public function datatablesindex(){
        if($this->slugpermision()){
            $tanques=Tanque::
            select('tanques.*');
            return DataTables::of(
                $tanques
            )
            ->addColumn( 'btnContrato', '<a class="btn btn-grisclaro btn-xs" href="{{route(\'contrato.index\', $id)}}"><span class="fas fa-clipboard"></span></a>')
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnContrato','btnShow','btnEdit','btnDelete'])
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
            ]);

            $tanques=new Tanque;
            $tanques->num_serie = $request->input('num_serie');
            $tanques->ph = $request->input('ph');
            $tanques->capacidad = $request->input('capacidad');
            $tanques->material = $request->input('material');
            $tanques->fabricante = $request->input('fabricante');
            $tanques->tipo_gas = $request->input('tipo_gas');

            if($tanques->save()){
                return response()->json(['mensaje'=>' Registrado Correctamente']);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show(Tanque $id){
        if($this->slugpermision()){
            $data=['tanques'=>$id];
            return $data;
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

            if($tanques->save()){
                return response()->json(['mensaje'=>' Editado Correctamente']);
            }
            return response()->json(['mensaje'=>'No Editado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function destroy(Tanque $id)
    {
        if($this->slugpermision()){

            if($id->delete()){
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }
}