<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use App\Models\CatalogoGas;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CatalogoGasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }

    protected function validator(array $data,$id){
        return Validator::make($data, [
            'nombre' => ['required', 'string','max:255', Rule::unique('catalogo_gases')->ignore($id, 'id')],
            'abreviatura' => ['required', 'string', 'max:255', Rule::unique('catalogo_gases')->ignore($id, 'id')],
        ]);
    }

    public function index(){
        if($this->slug_permiso('gas_show')){
            return view('gas.index');
        }
        return view('home');
    }

    public function gas_data(){
        if($this->slug_permiso('gas_show')){
            $gases=CatalogoGas::
            select('catalogo_gases.*');
            return DataTables::of(
                $gases
            )                                                               
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-verde btn-edit-modal btn-xs" data-id="{{$id}}" title="Editar"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDestroy', '<button class="btn btn-sm btn-verde btn-delete-modal btn-xs" data-id="{{$id}}" title="Baja"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnEdit','btnDestroy'])
            ->toJson();
        }
        return view('home');
    }

    public function show( CatalogoGas $id){
        if($this->slug_permiso('gas_show')){
            return $id;
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function create(Request $request){
        if($this->slug_permiso('gas_create')){
            $request->validate([
                'nombre' => ['required', 'string', 'max:255','unique:catalogo_gases,nombre'],
                'abreviatura' => ['required', 'string', 'max:255', 'unique:catalogo_gases,abreviatura'],
            ]);
            $gas=new CatalogoGas;
            $gas->nombre = $request->input('nombre');
            $gas->abreviatura = $request->input('abreviatura');
            
            if($gas->save()){
                return response()->json(['mensaje'=>' Registrado Correctamente']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }
    
    public function update(Request $request, $id){
        if($this->slug_permiso('gas_update')){
            $this->validator($request->all(), $id)->validate();

            $gas=CatalogoGas::find( $id);
            $gas->nombre = $request->input('nombre');
            $gas->abreviatura = $request->input('abreviatura');
            
            if($gas->save()){
                return response()->json(['mensaje'=>' Registrado Correctamente']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function destroy(CatalogoGas $id){
        if($this->slug_permiso('gas_delete')){
            if($id->delete()){
                return response()->json(['mensaje'=>'Eliminado correctamente']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function catalogo_gases(){

        $gases=CatalogoGas::all();
        return $gases;
    }

    public function nombre_gas($id){
        $nombre= CatalogoGas::select('nombre')->where('id',$id)->first();
        return $nombre->nombre;
    }
}
