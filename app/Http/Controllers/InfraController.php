<?php

namespace App\Http\Controllers;

use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\Tanque;
use App\Models\TanqueHistorial;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InfraController extends Controller
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
        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            return view('infra.index');
        }
        return view('home');
    }

    public function data(){
        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $infra=InfraLLenado::all();
            return DataTables::of(
                $infra
            )
            ->editColumn('created_at', function ($infra) {
                return $infra->created_at->format('H:i:s A - d/m/Y');
            })
            ->addColumn( 'btnShow', '<button class="btn btn-verde btn-show btn-sm" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.infra_nota\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->rawColumns(['btnShow','btnPDF'])
            ->toJson();
        }
        return view('home');
    }

    public function entrada(){
        if($this->slug_permiso('infra_entrada')){
            return view('infra.entrada');
        }
        return view('home');
    }
    public function salida(){
        if($this->slug_permiso('infra_salida')){
            return view('infra.salida');
        }
        return view('home');
    }

    public function registro_save(Request $request){

        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $request->validate([
                // 'fecha' => ['required'],
                'cantidad' => ['required', 'int'],
                'incidencia' => ['required', 'string', 'max:255'],
            ]);

            $fechaactual=date("Y")."-" . date("m")."-".date("d");

            $infra=new InfraLLenado;
            $infra->cantidad= $request->cantidad;
            $infra->fecha= $fechaactual;
            $infra->incidencia= $request->incidencia;
            $infra->user_id=auth()->user()->id;


            if($infra->save()){
                if($infra->incidencia=='ENTRADA'){
                    $obse_hystory='Regreso de INFRA. Nota id: '. $infra->id;
                    $estatus_tanque='LLENO-ALMACEN';
                }else{
                    $obse_hystory='Llevado a INFRA. Nota id: '. $infra->id;
                    $estatus_tanque='INFRA';
                }
                foreach( $request->inputNumSerie AS $series => $g){
                    $infratanque=new InfraTanque;
                    $infratanque->num_serie = $request->inputNumSerie[$series];
                    $infratanque->infrallenado_id = $infra->id;
                    $infratanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = $estatus_tanque;
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $request->inputNumSerie[$series];
                    $historytanques->estatus = $estatus_tanque;
                    $historytanques->observaciones =$obse_hystory;
                    $historytanques->save();
                }
                return response()->json(['notaId'=>$infra->id]);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function show(InfraLLenado $id){
        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $tanques=InfraTanque::
                join('tanques', 'tanques.num_serie', 'infra_tanques.num_serie')
                ->where('infrallenado_id', $id->id)
                ->get();
            $data = ['infranota'=>$id, 'tanques' => $tanques];
            return view('infra.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }

}
