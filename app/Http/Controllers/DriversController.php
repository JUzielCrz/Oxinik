<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Driver;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;


class DriversController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if ($user->permiso_con_admin('drivers_show')){
            return true;
        }else{
            return view('home');
        };
    }

    public function index()
    {
        $this->slug_permiso();
        return view('drivers.index');
    }

    public function data(){
        $this->slug_permiso();
            $drivers=Driver::all();
            return DataTables::of(
                $drivers
            )                                                               
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-verde btn_modal_driver btn-xs" data-id="{{$id}}" title="Editar"><span class="far fa-edit"></span></button>')
            ->rawColumns(['btnEdit'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $this->slug_permiso();
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'licencia_tipo' => ['required', 'string', 'max:255'],
            'licencia_numero' => ['required', 'string', 'max:255'],
        ]);
        $driver = new Driver();
        $driver->nombre = $request->input('nombre');
        $driver->apellido = $request->input('apellido');
        $driver->licencia_tipo = $request->input('licencia_tipo');
        $driver->licencia_numero = $request->input('licencia_numero');
        $driver->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Registrado Correctamente']);
    }

    public function show($id)
    {
        $this->slug_permiso();
        $driver=Driver::find($id);
        return $driver;
    }

    public function update(Request $request, $id)
    {
        $this->slug_permiso();
        $driver=Driver::find( $id);
        $driver->nombre = $request->input('nombre');
        $driver->apellido = $request->input('apellido');
        $driver->licencia_tipo = $request->input('licencia_tipo');
        $driver->licencia_numero = $request->input('licencia_numero');
        $driver->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Editado Correctamente']);
    }

}
