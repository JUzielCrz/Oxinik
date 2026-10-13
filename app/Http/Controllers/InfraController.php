<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGas;
use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\Tanque;
use App\User;
use App\Http\Requests\InfraSalidaRequest;
use App\Services\InfraSalidaService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InfraController extends Controller
{

    protected $infraSalidaService;

    public function __construct(InfraSalidaService $infraSalidaService)
    {
        $this->middleware('auth');
        $this->infraSalidaService = $infraSalidaService;
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
                return $infra->created_at->format('Y/m/d - H:i:s A');
            })
            ->editColumn('mostrar_diferencia', function ($infra) {
                if($infra->pendiente == true){
                    return $infra->cantidad_diferencia;
                }else{
                    return 0;
                }
            })
            ->addColumn('estado', function ($infra) {
                if ($infra->cantidad_entrada === null) {
                    return '<span class="infra-status infra-status-pending">Pendiente de entrada</span>';
                }

                if ($infra->pendiente == true && (int) $infra->cantidad_diferencia > 0) {
                    return '<span class="infra-status infra-status-difference">Con diferencia</span>';
                }

                return '<span class="infra-status infra-status-complete">Completada</span>';
            })
            ->addColumn('btnEntrada', '<a class="btn btn-verde btn-sm" href="{{route(\'infra.entrada\', $id)}}" data-toggle="tooltip" data-placement="top" title="Registrar entrada"><i class="fas fa-warehouse"></i><span class="sr-only">Registrar entrada</span></a>')
            ->addColumn('btnShow', '<button type="button" class="btn btn-verde btn-show btn-sm" data-id="{{$id}}" data-toggle="tooltip" data-placement="top" title="Ver detalle"><span class="far fa-eye"></span><span class="sr-only">Ver detalle</span></button>')
            ->addColumn('btnPDF', '<a class="btn btn-verde btn-sm" href="{{route(\'pdf.infra_nota\', $id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Descargar PDF"><i class="fas fa-file-pdf"></i><span class="sr-only">Descargar PDF</span></a>')
            ->rawColumns(['estado','btnEntrada','btnShow','btnPDF'])
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

    public function salida_save(InfraSalidaRequest $request){

        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $infra = $this->infraSalidaService->registrar(
                $request->input('inputNumSerie'),
                $request->input('cantidad'),
                auth()->user()->id
            );

            return response()->json(['notaId' => $infra->id]);
        }
        return response()->json(['mensaje'=>'Sin permisos']);

    }

    public function entrada($id){
        if($this->slug_permiso('infra_entrada')){
            $catalogo = CatalogoGas::pluck('nombre','id');
            $nota_salida = InfraLLenado::find($id);
            $tanques= InfraTanque::
            join('tanques','tanques.num_serie','=','infra_tanques.num_serie')->select('tanques.*')->where('infrallenado_id',$id)->where('incidencia','ENTRADA')->get();
            $data=['catalogo'=> $catalogo, 'nota'=>$nota_salida,'tanques'=>$tanques];
            return view('infra.entrada', $data);
        }
        return view('home');
    }

    public function entrada_save(Request $request){
        
        if($this->slug_permiso('infra_salida') || $this->slug_permiso('infra_entrada')){
            $request->validate([
                'cantidad_entrada' => ['required', 'int'],
                'inputEstatus' => ['required', 'array'],
                'inputEstatus.*' => ['required', 'string', 'max:255']
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
                    if(InfraTanque::where('num_serie',$request->inputNumSerie[$series])->where('infrallenado_id', $infra->id)->where('incidencia','ENTRADA')->first() == null){
                        $infratanque=new InfraTanque;
                        $infratanque->num_serie = $request->inputNumSerie[$series];
                        $infratanque->infrallenado_id = $infra->id;
                        $infratanque->incidencia = 'ENTRADA';
                        $infratanque->save();
    
                        $tanque=Tanque::where('num_serie',$request->inputNumSerie[$series])->first();
                        $tanque->estatus = $request->inputEstatus[$series];
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
