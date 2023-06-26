<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Concentrator;
use Yajra\DataTables\DataTables;


class ConcentratorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if ($user->permiso_con_admin('concentrator_show')){
            return true;
        }else{
            return view('home');
        };
    }

    public function index()
    {
        $this->slug_permiso();
        return view('concentrator.concentrators');
    }

    public function data(){
        $this->slug_permiso();
            $concentrators=Concentrator::all();
            return DataTables::of(
                $concentrators
            )                                                               
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-verde btn_modal_concentrators btn-xs" data-id="{{$id}}" title="Editar"><span class="far fa-edit"></span></button>')
            ->rawColumns(['btnEdit'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $this->slug_permiso();
        $request->validate([
            'serial_number' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'work_hours' => ['required', 'string', 'max:255'],
            'capacity' => ['required'],
            'description' => ['required', 'string'],
        ]);
        $concentrator = new Concentrator();
        $concentrator->serial_number = $request->input('serial_number');
        $concentrator->brand = $request->input('brand');
        $concentrator->work_hours = $request->input('work_hours');
        $concentrator->capacity = $request->input('capacity');
        $concentrator->status = "ALMACEN";
        $concentrator->description = $request->input('description');
        $concentrator->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Registrado Correctamente']);
    }

    public function show($id)
    {
        $this->slug_permiso();
        $concentrator=Concentrator::find($id);
        return $concentrator;
    }

    public function show_serial($serial_number)
    {
        $this->slug_permiso();
        $concentrator=Concentrator::where('serial_number', $serial_number)->first();
        return $concentrator;
    }

    public function update(Request $request, $id)
    {
        $this->slug_permiso();
        $concentrator=Concentrator::find( $id);
        $concentrator->serial_number = $request->input('serial_number');
        $concentrator->brand = $request->input('brand');
        $concentrator->work_hours = $request->input('work_hours');
        $concentrator->capacity = $request->input('capacity');
        $concentrator->description = $request->input('description');
        $concentrator->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Editado Correctamente']);
    }

    // public function update_hours(Request $request, $concentrator_id){
    //     $concentrator=Concentrator::find( $concentrator_id);
    //     $concentrator->work_hours = $request->result_operation_edit;
    //     $concentrator->save();
    //     return $concentrator->work_hours;
    //     // $concentrator->work_hours = $request->input('work_hours');
    // }
}
