<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoLLenado;
use App\Models\MantenimientoTanque;
use App\Models\Tanque;
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
            ->editColumn('pendiente', function ($mantenimiento) {
                if($mantenimiento->pendiente == true){
                    return "PENDIENTE";
                }else{
                    return '-';
                }
            })
            ->addColumn( 'btnEntrada', '<a class="btn btn-verde btn-sm" href="{{route(\'mantenimiento.entrada\', $id)}}" data-toggle="tooltip" data-placement="top" title="Registra Entrada"><i class="fas fa-warehouse"></i></a>')
            ->addColumn( 'btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.mantenimiento_nota\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->rawColumns(['btnEntrada','btnShow', 'btnPDF'])
            ->toJson();
        }
        return view('home');
    }

    public function entrada($id){
        if($this->slug_permiso('mantenimiento_entrada')){
            $nota=MantenimientoLLenado::find($id);
            $tanques=MantenimientoTanque::
            join('tanques', 'tanques.num_serie','=','mantenimiento_tanques.num_serie')
            ->where('mantenimientollenado_id',$id)->get();
            return view('mantenimiento.entrada', compact('tanques', 'nota'));
        }
        return view('home');
    }
    public function salida(){
        if($this->slug_permiso('mantenimiento_salida')){
            return view('mantenimiento.salida');
        }
        return view('home');
    }

    public function registro_salida(Request $request){
        if($this->slug_permiso('mantenimiento_salida')){
            $request->validate([
                'cantidad' => ['required', 'int'],
                'incidencia' => ['required', 'string', 'max:255'],

            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

            $mantenimiento=new MantenimientoLLenado;
            $mantenimiento->cantidad= $request->cantidad;
            $mantenimiento->fecha= $fechaactual;
            $mantenimiento->save();

            foreach( $request->inputNumSerie AS $series => $g){
                $mantenimientoTanque=new MantenimientoTanque;
                $mantenimientoTanque->num_serie = $request->inputNumSerie[$series];
                $mantenimientoTanque->mantenimientoLLenado_id = $mantenimiento->id;
                $mantenimientoTanque->folio_talon = $request->inputTalon[$series];
                $mantenimientoTanque->incidencia = $request->incidencia;
                $mantenimientoTanque->user_id = auth()->user()->id;
                $mantenimientoTanque->save();

                $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                $tanque->estatus = 'MANTENIMIENTO';
                $tanque->ph = $request->inputPH[$series];
                $tanque->save();
            }
            return response()->json(['notaId'=>$mantenimiento->id]);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function registro_entrada(Request $request){
        if($this->slug_permiso('mantenimiento_salida') || $this->slug_permiso('mantenimiento_entrada')){
            $request->validate([
                'cantidad' => ['required', 'int'],
                'incidencia' => ['required', 'string', 'max:255'],

            ]);
            $mantenimiento=MantenimientoLLenado::find($request->nota_id);
            $mantenimiento->pendiente= $request->pendiente;
            $mantenimiento->save();
            
                foreach( $request->inputNumSerie AS $series => $g){
                    $mantenimientoTanque=new MantenimientoTanque;
                    $mantenimientoTanque->num_serie = $request->inputNumSerie[$series];
                    $mantenimientoTanque->mantenimientoLLenado_id = $request->nota_id;
                    $mantenimientoTanque->incidencia = $request->incidencia;
                    $mantenimientoTanque->user_id = auth()->user()->id;
                    $mantenimientoTanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = 'LLENO-ALMACEN';
                    $tanque->ph = $request->inputPH[$series];
                    $tanque->save();
                }
                return response()->json(['notaId'=>$request->nota_id]);
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function show(MantenimientoLLenado $id){
        if($this->slug_permiso('mantenimiento_salida') || $this->slug_permiso('mantenimiento_entrada')){
        $tanques=MantenimientoTanque::
                join('tanques', 'tanques.num_serie', 'mantenimiento_tanques.num_serie')
                ->where('mantenimiento_tanques.mantenimientollenado_id', $id->id)
                ->get();
            $data = ['mantenimientonota'=>$id, 'tanques' => $tanques];
            return view('mantenimiento.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }
}
