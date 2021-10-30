<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoLLenado;
use App\Models\MantenimientoTanque;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MantenimientoController extends Controller
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


    public function index(){
        if($this->slug_permiso('mantenimiento_salida') || $this->slug_permiso('mantenimiento_entrada')){
            return view('mantenimiento.index');
        }
        return view('home');
    }

    public function data(){
        if($this->slug_permiso('mantenimiento_salida') || $this->slug_permiso('mantenimiento_entrada')){
            $mantenimiento=MantenimientoLLenado::all();
            return DataTables::of(
                $mantenimiento
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show btn-sm" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnPDF', '<a class="btn btn-grisclaro btn-sm" href="{{route(\'pdf.mantenimiento_nota\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->rawColumns(['btnShow', 'btnPDF'])
            ->toJson();
        }
        return view('home');
    }

    public function entrada(){
        if($this->slug_permiso('mantenimiento_entrada')){
            return view('mantenimiento.entrada');
        }
        return view('home');
    }
    public function salida(){
        if($this->slug_permiso('mantenimiento_salida')){
            return view('mantenimiento.salida');
        }
        return view('home');
    }

    public function registro_save(Request $request){

        if($this->slug_permiso('mantenimiento_salida') || $this->slug_permiso('mantenimiento_entrada')){
            $request->validate([
                // 'fecha' => ['required'],
                'cantidad' => ['required', 'int'],
                'incidencia' => ['required', 'string', 'max:255'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

            $mantenimiento=new MantenimientoLLenado;
            $mantenimiento->cantidad= $request->cantidad;
            $mantenimiento->fecha= $fechaactual;
            $mantenimiento->incidencia= $request->incidencia;

            if($mantenimiento->save()){
                if($mantenimiento->incidencia=='ENTRADA'){
                    $obse_hystory='Regreso de MANTENIMIENTO. Nota id: '. $mantenimiento->id;
                    $estatus_tanque='LLENO-ALMACEN';
                }else{
                    $obse_hystory='Llevado a MANTENIMIENTO. Nota id: '. $mantenimiento->id;
                    $estatus_tanque='MANTENIMIENTO';
                }
                foreach( $request->inputNumSerie AS $series => $g){
                    $mantenimientoTanque=new MantenimientoTanque;
                    $mantenimientoTanque->num_serie = $request->inputNumSerie[$series];
                    $mantenimientoTanque->mantenimientoLLenado_id = $mantenimiento->id;
                    $mantenimientoTanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = $estatus_tanque;
                    $tanque->ph = $request->idInputPH[$series];
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $request->inputNumSerie[$series];
                    $historytanques->estatus = $estatus_tanque;
                    $historytanques->observaciones =$obse_hystory;
                    $historytanques->save();
                }
                return response()->json(['notaId'=>$mantenimiento->id]);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function show(MantenimientoLLenado $id){
        if($this->slug_permiso('mantenimiento_salida') || $this->slug_permiso('mantenimiento_entrada')){
            $tanques=MantenimientoLLenado::
                join('tanques', 'tanques.num_serie', 'mantenimiento_tanques.num_serie')
                ->where('mantenimientoLLenado_id', $id->id)
                ->get();
            $data = ['mantenimientonota'=>$id, 'tanques' => $tanques];
            return view('mantenimiento.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }
}
