<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use App\Models\Contrato;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slug_permiso($slug_permiso){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->permiso_con_admin($slug_permiso);
    }

    public function index()
    {
        if($this->slug_permiso('cliente_show')){
            return view('clientes.index');
        }
        return view('home');
    }

    public function data($estatus){
        // dump('pasas');
        if($this->slug_permiso('cliente_show')){
            $clientes=Cliente::
            where('estatus', $estatus);
            return DataTables::of(
                $clientes
            )
            ->addColumn( 'btnShow', '<a class="btn btn-sm btn-verde" href="{{route(\'client.show\', $id)}}" data-toggle="tooltip" data-placement="top" title="Visualizar Datos"><span class="far fa-eye"></span> ver</a>')
            ->addColumn( 'btnEdit',     '<button class="btn btn-sm btn-verde btn-edit-modal" data-id="{{$id}}" data-toggle="tooltip" data-placement="top" title="Editar"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete',   '<button class="btn btn-sm btn-verde btn-delete-modal" data-id="{{$id}}" data-toggle="tooltip" data-placement="top" title="Eliminar"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnContrato','btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }


    public function create(Request $request)
    {
        if($this->slug_permiso('cliente_create')){

            $request->validate([
                'tipo-cliente' => ['required'],
                'apPaterno' => ['required', 'string', 'max:255'],
                'apMaterno' => ['required', 'string', 'max:255'],
                'nombre' => ['required', 'string', 'max:255'],
                'rfc' => ['required', 'string', 'max:255'],
                'telefono' => ['required', 'string', 'max:255'],
                'telefonorespaldo' => ['required', 'string', 'max:255'],
                'estatus' => ['required', 'string', 'max:255'],
            ]);

            if($request->input('tipo-cliente') == 'EMPRESA'){
                $request->validate([
                    'empresa' => ['required', 'string', 'max:255'],
                ]);
            }

            $clientes=new Cliente;
            $clientes->apPaterno = $request->input('apPaterno');
            $clientes->apMaterno = $request->input('apMaterno');
            $clientes->nombre = $request->input('nombre');
            $clientes->empresa = $request->input('empresa');
            $clientes->rfc = $request->input('rfc');
            $clientes->email = $request->input('email');
            $clientes->telefono = $request->input('telefono');
            $clientes->telefonorespaldo = $request->input('telefonorespaldo');
            $clientes->direccion = $request->input('direccion');
            $clientes->referencia = $request->input('referencia');
            $clientes->estatus = $request->input('estatus');
            $clientes->save();

            return response()->json(['mensaje'=>' Registrado Correctamente']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show($id){
        $client = Cliente::find($id);
        $agreements= Contrato::where("cliente_id", $id)->get();
        $data=["client" => $client, "agreements"=>$agreements];
        return view('clientes.show', $data);
    }

    public function update(Request $request, $id)
    {
        if($this->slug_permiso('cliente_update')){

            if($request->input('tipo-cliente') == 'PERSONA'){
                $request->validate([
                    'apPaterno' => ['required', 'string', 'max:255'],
                    'apMaterno' => ['required', 'string', 'max:255'],
                    'nombre' => ['required', 'string', 'max:255'],
                ]);
            }
            if($request->input('tipo-cliente') == 'EMPRESA'){
                $request->validate([
                    'empresa' => ['required', 'string', 'max:255'],
                ]);
            }
            $request->validate([
                'rfc' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                // 'email' => ['required', 'email', 'max:255','unique:clientes,email'],
                'telefono' => ['required', 'string', 'max:255'],
                'telefonorespaldo' => ['required', 'string', 'max:255'],
                'direccion' => ['required', 'string', 'max:255'],
                'referencia' => ['required', 'string', 'max:255'],
                'estatus' => ['required', 'string', 'max:255'],
            ]);

            $clientes=  Cliente::find($id);
            $clientes->empresa = $request->input('empresa');
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
        if($this->slug_permiso('cliente_delete')){
            $id->delete();
            return response()->json(['mensaje'=>'Eliminado Correctamente']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }
}