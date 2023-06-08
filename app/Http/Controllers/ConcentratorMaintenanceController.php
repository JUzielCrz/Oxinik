<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ConcentratorMaintenance;
use App\Models\Concentrator;
use Yajra\DataTables\DataTables;

class ConcentratorMaintenanceController extends Controller
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
        return view('concentrator.maintenance.index');
    }

    public function data(){
        $this->slug_permiso();
            $concentrators=ConcentratorMaintenance::all();
            return DataTables::of(
                $concentrators
            )
            ->editColumn('user_name', function ($user) {
                if($user->user_id == null){
                    return null;
                }else{
                    $usuario=User::find($user->user_id )->first();
                    return $usuario->name;
                }
            })    
            ->editColumn('created_at', function ($formatDate) {
                return $formatDate->created_at->format('Y/m/d - H:i:s A');
            })                                                            
            ->addColumn( 'buttons', '<button class="btn btn-sm btn-verde btn_return_maintenance" data-id="{{$id}}" title="Editar"><i class="fas fa-undo-alt"></i></button>
            <button class="btn btn-sm btn-verde btn_destroy" data-id="{{$id}}" title="Eliminar"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['buttons'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $this->slug_permiso();
        $request->validate([
            'serial_number' => ['required', 'string', 'max:255'],
        ]);

        $concentrator = Concentrator::where('serial_number', $request->serial_number)->first();
        $maintenence = new ConcentratorMaintenance();
        $maintenence->concentrator_id =  $concentrator->id;
        $maintenence->serial_number =  $concentrator->serial_number;
        $maintenence->status = 'PENDIENTE';
        $maintenence->observations = $request->observations;
        $maintenence->user_id = auth()->user()->id;
        $maintenence->save();

        $concentrator->status = 'MANTENIMIENTO';
        $concentrator->save();
        return response()->json(['type_alert'=>'success', 'msg_text'=>'Registrado Correctamente']);
    }

    public function edit(ConcentratorMaintenance $id)
    {
        $this->slug_permiso();
        return $id;
    }

    // public function show_serial($serial_number)
    // {
    //     $this->slug_permiso();
    //     $concentrator=Concentrator::where('serial_number', $serial_number)->first();
    //     return $concentrator;
    // }

    public function update(Request $request, $id)
    {
        $maintenence = ConcentratorMaintenance::find($id);
        $concentrator = Concentrator::find($maintenence->concentrator_id);
        $currentDate = date('Y-m-d H:i:s');
        if($request->status_edit == 'OK'){
            $maintenence->date_return = $currentDate;
            $concentrator->status = 'ALMACEN';
            $maintenence->status = 'OK';
        }else{
            $concentrator->status = 'MANTENIMIENTO';
            $maintenence->status = 'PENDIENTE';
        }
       
        $maintenence->observations = $request->observations_edit;
        $maintenence->save();
        $concentrator->save();

        return  $request->all();
    }

    public function destroy(ConcentratorMaintenance $id)
    {
        $this->slug_permiso();
        $concentrator=Concentrator::where('serial_number', $id->serial_number)->first();
        $concentrator->status = 'ALMACEN';
        $concentrator->save();
        $id->delete();
        return true;
    }

}
