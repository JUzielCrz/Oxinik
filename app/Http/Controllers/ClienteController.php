<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('clientes');
    }

    protected function validator(array $data,$id)
    {
        return Validator::make($data, [
            'apPaterno' => ['required', 'string', 'max:255'],
            'apMaterno' => ['required', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'rfc' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email','max:255', Rule::unique('clientes')->ignore($id, 'id')],
            'telefono' => ['required', 'string', 'max:255'],
            'telefonorespaldo' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'referencia' => ['required', 'string', 'max:255'],
            'estatus' =>  ['required', 'alpha', 'max:20','regex:(Activo|Inactivo|Cancelado)'],
        ]);
    }

    public function index()
    {
        if($this->slugpermision()){
            return view('clientes.index');
        }
        return view('home');
    }

    public function datatablesindex(){
        if($this->slugpermision()){
            $clientes=Cliente::
            select('clientes.*');
            return DataTables::of(
                $clientes
            )
            ->addColumn( 'btnContrato', '<a class="btn btn-grisclaro btn-xs" href="{{route(\'contrato.index\', $id)}}"><span class="fas fa-clipboard"></span></a>')
            // ->addColumn( 'btnContrato', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
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
                'apPaterno' => ['required', 'string', 'max:255'],
                'apMaterno' => ['required', 'string', 'max:255'],
                'nombre' => ['required', 'string', 'max:255'],
                'rfc' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255','unique:clientes,email'],
                'telefono' => ['required', 'string', 'max:255'],
                'telefonorespaldo' => ['required', 'string', 'max:255'],
                'direccion' => ['required', 'string', 'max:255'],
                'referencia' => ['required', 'string', 'max:255'],
                'estatus' => ['required', 'string', 'max:255'],
            ]);

            $clientes=new Cliente;
            $clientes->apPaterno = $request->input('apPaterno');
            $clientes->apMaterno = $request->input('apMaterno');
            $clientes->nombre = $request->input('nombre');
            $clientes->rfc = $request->input('rfc');
            $clientes->email = $request->input('email');
            $clientes->telefono = $request->input('telefono');
            $clientes->telefonorespaldo = $request->input('telefonorespaldo');
            $clientes->direccion = $request->input('direccion');
            $clientes->referencia = $request->input('referencia');
            $clientes->estatus = $request->input('estatus');

            if($clientes->save()){
                return response()->json(['mensaje'=>' Registrado Correctamente']);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show(Cliente $id){
        if($this->slugpermision()){
            $data=['clientes'=>$id];
            return $data;
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function update(Request $request, $id)
    {
        if($this->slugpermision()){

            $this->validator($request->all(),$id)->validate();

            $clientes=  Cliente::find($id);
            $clientes->apPaterno = $request->input('apPaterno');
            $clientes->apMaterno = $request->input('apMaterno');
            $clientes->nombre = $request->input('nombre');
            $clientes->rfc = $request->input('rfc');
            $clientes->email = $request->input('email');
            $clientes->telefono = $request->input('telefono');
            $clientes->telefonorespaldo = $request->input('telefonorespaldo');
            $clientes->direccion = $request->input('direccion');
            $clientes->referencia = $request->input('referencia');
            $clientes->estatus = $request->input('estatus');

            if($clientes->save()){
                return response()->json(['mensaje'=>' Editado Correctamente']);
            }
            return response()->json(['mensaje'=>'No Editado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function destroy(Cliente $id)
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