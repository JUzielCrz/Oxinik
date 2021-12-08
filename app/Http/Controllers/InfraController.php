<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
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
            ->editColumn('mostrar_diferencia', function ($infra) {
                if($infra->pendiente == true){
                    return $infra->cantidad_diferencia;
                }else{
                    return 0;
                }
            })
            ->addColumn( 'btnEntrada', '<a class="btn btn-verde btn-sm" href="{{route(\'infra.entrada\', $id)}}" data-toggle="tooltip" data-placement="top" title="Registra Entrada"><i class="fas fa-warehouse"></i></a>')
            ->addColumn( 'btnShow', '<button class="btn btn-verde btn-show btn-sm" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.infra_nota\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Nota PDF"><i class="fas fa-file-pdf"></i></a>')
            ->rawColumns(['btnEntrada','btnShow','btnPDF'])
            ->toJson();
        }
        return view('home');
    }

    
    public function salida(){
        if($this->slug_permiso('infra_salida')){
            return view('infra.salida');
        }
        return view('home');
    }

    public function salida_save(Request $request){

        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $request->validate([
                'cantidad' => ['required', 'int']
            ]);

            $infra=new InfraLLenado;
            $infra->cantidad_salida= $request->cantidad;
            $infra->user_id = auth()->user()->id;

            if($infra->save()){
                foreach( $request->inputNumSerie AS $series => $g){
                    $infratanque=new InfraTanque;
                    $infratanque->num_serie = $request->inputNumSerie[$series];
                    $infratanque->infrallenado_id = $infra->id;
                    $infratanque->incidencia = 'SALIDA';
                    $infratanque->save();

                    $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                    $tanque->estatus = 'INFRA';
                    $tanque->save();

                    $historytanques=new TanqueHistorial;
                    $historytanques->num_serie = $request->inputNumSerie[$series];
                    $historytanques->estatus = 'INFRA';
                    $historytanques->observaciones ='Llevado a INFRA. Nota id: '. $infra->id;
                    $historytanques->save();
                }
                return response()->json(['notaId'=>$infra->id]);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function entrada($id){
        if($this->slug_permiso('infra_entrada')){
            $catalogo = CatalogoGas::pluck('nombre','id');
            $nota_salida = InfraLLenado::select('id','cantidad_salida', 'pendiente', 'observaciones')->where('id',$id)->first();
            $tanques= InfraTanque::
            join('tanques','tanques.num_serie','=','infra_tanques.num_serie')->select('tanques.*')->where('infrallenado_id',$id)->where('incidencia','ENTRADA')->get();
            $data=['catalogo'=> $catalogo, 'nota'=>$nota_salida,'tanques'=>$tanques];
            return view('infra.entrada', $data);
        }
        return view('home');
    }

    public function entrada_save(Request $request){
        // dump($request->all());
        // return false;
        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $request->validate([
                'cantidad_entrada' => ['required', 'int']
            ]);
            if ($request->cantidad_entrada > $request->cantidad_salida) {
                return response()->json(['alert'=>'error', 'mensaje'=>'Cantidad Entrada no puede ser mayor a cantidad salida']);
            }

            if($request->pendiente == null){
                $vapendiente =true;
            }else{
                $vapendiente =false;
            }
            $infra=InfraLLenado::find($request->nota_id);
            $infra->cantidad_entrada= $request->cantidad_entrada;
            $infra->cantidad_diferencia= $request->cantidad_diferencia;
            $infra->pendiente=  $vapendiente;
            $infra->observaciones= $request->observaciones;
            $infra->user_id = auth()->user()->id;
            $infra->save();
                foreach( $request->inputNumSerie AS $series => $g){
                    if(InfraTanque::where('num_serie',$request->inputNumSerie[$series])->where('incidencia','ENTRADA')->first() == null){
                        $infratanque=new InfraTanque;
                        $infratanque->num_serie = $request->inputNumSerie[$series];
                        $infratanque->infrallenado_id = $infra->id;
                        $infratanque->incidencia = 'ENTRADA';
                        $infratanque->save();
    
                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = 'LLENO-ALMACEN';
                        $tanque->save();
                    }
                }
                return response()->json(['alert'=>'success', 'mensaje'=>'Registrado Correctamente']);
        }
        return response()->json(['alert'=>'error', 'mensaje'=>'Sin permisos']);

    }

    public function show(InfraLLenado $id){
        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $tanques=InfraTanque::
                join('tanques', 'tanques.num_serie', 'infra_tanques.num_serie')
                ->where('infrallenado_id', $id->id)
                ->get();
            $usuario= User::select('name')->where('id', $id->user_id)->first();
            $data = ['infranota'=>$id, 'tanques' => $tanques, 'usuario'=>$usuario];
            return view('infra.show', $data);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }

}
