<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Car;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if ($user->permiso_con_admin('cars_show')){
            return true;
        }else{
            return view('home');
        };
    }

    public function index()
    {
        $this->slug_permiso();
        return view('cars.index');
    }

    public function data(){
        $this->slug_permiso();
            $cars=Car::all();
            return DataTables::of(
                $cars
            )                                                               
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-verde btn_modal_car btn-xs" data-id="{{$id}}" title="Editar"><span class="far fa-edit"></span></button>')
            ->rawColumns(['btnEdit'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $this->slug_permiso();
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'placa' => ['required', 'string', 'max:255'],
        ]);
        $car = new Car();
        $car->nombre = $request->input('nombre');
        $car->modelo = $request->input('modelo');
        $car->marca = $request->input('marca');
        $car->placa = $request->input('placa');
        $car->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Registrado Correctamente']);
    }

    public function show($id)
    {
        $this->slug_permiso();
        $car=Car::find($id);
        return $car;
    }

    public function update(Request $request, $id)
    {
        $this->slug_permiso();
        $car=Car::find( $id);
        $car->nombre = $request->input('nombre');
        $car->modelo = $request->input('modelo');
        $car->marca = $request->input('marca');
        $car->placa = $request->input('placa');
        $car->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Editado Correctamente']);
    }

}
