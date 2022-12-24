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
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ]);
        $driver = new Driver();
        $driver->name = $request->input('name');
        $driver->last_name = $request->input('last_name');
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
        $driver->name = $request->input('name');
        $driver->last_name = $request->input('last_name');
        $driver->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Editado Correctamente']);
    }

}
