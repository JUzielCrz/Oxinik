<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\NotaEntrada;
use App\Models\VentaExporadica;
use Yajra\DataTables\DataTables;

use App\User;

class NotaListasController extends Controller
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
        if($this->slug_permiso('nota_show')){
            return view('notas.listas.index');
        }
        return view('home');
    }

    public function salidas_data(){
        if($this->slug_permiso('nota_show')){
            $nota_entrada=Nota::
            join('contratos','contratos.id','=','notas.contrato_id')
            ->select('notas.id as nota_id',
                    'contratos.num_contrato',
                    'notas.fecha',
                    'notas.pago_cubierto',
                    'notas.observaciones',
                    'notas.user_id');
            return DataTables::of(
                $nota_entrada
            )                                       
            ->editColumn('pago_cubierto', function ($nota) {
                if($nota->pago_cubierto== true){
                    return 'Pagado';
                }else{
                    return 'Adeuda';
                }
            })
            ->editColumn('user_name', function ($nota) {
                if($nota->user_id == null){
                    return null;
                }else{
                    $usuario=User::select('name')->where('id', $nota->user_id)->first();
                    return $usuario->name;
                }
            })
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'pdf.nota_salida\', $nota_id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
            ->toJson();
        }
        return view('home');
    }

    public function exporadica_data(){
        if($this->slug_permiso('nota_show')){
            $nota_entrada=VentaExporadica::all();
            return DataTables::of(
                $nota_entrada
            )                                                               
            ->editColumn('user_name', function ($nota) {
                if($nota->user_id == null){
                    return null;
                }else{
                    $usuario=User::select('name')->where('id', $nota->user_id)->first();
                    return $usuario->name;
                }
            })
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'pdf.nota_exporadica\', $id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
            ->toJson();
        }
        return view('home');
    }

    public function adeudos_data(){
        if($this->slug_permiso('nota_show')){
            $nota_entrada=Nota::
            join('contratos','contratos.id','=','notas.contrato_id')
            ->select('notas.id as nota_id',
                    'contratos.num_contrato',
                    'notas.fecha',
                    'notas.pago_cubierto',
                    'notas.observaciones',
                    'notas.user_id')
            ->where('notas.pago_cubierto', false);
            return DataTables::of(
                $nota_entrada
            )
            ->editColumn('user_name', function ($nota) {
                if($nota->user_id == null){
                    return null;
                }else{
                    $usuario=User::select('name')->where('id', $nota->user_id)->first();
                    return $usuario->name;
                }
            })                                                             
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'pdf.nota_salida\', $nota_id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->addColumn( 'btnShow', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'nota.pagos.index\', $nota_id)}}" title="Nota"><i class="far fa-eye"></i></a>')
            ->rawColumns(['btnNota','btnShow'])
            ->editColumn('pago_cubierto', function ($user) {
                if($user->pago_cubierto== true){
                    return 'Pagado';
                }else{
                    return 'Adeuda';
                }
            })
            ->toJson();
        }
        return view('home');
    }

    public function entradas_data(){
        if($this->slug_permiso('nota_show')){
            $nota_entrada=NotaEntrada::
            join('contratos','contratos.id','=','notas_entrada.contrato_id')
            ->select('notas_entrada.id as nota_id',
                    'contratos.num_contrato',
                    'notas_entrada.*',);
            return DataTables::of(
                $nota_entrada
            )
            ->editColumn('user_name', function ($nota) {
                if($nota->user_id == null){
                    return null;
                }else{
                    $usuario=User::select('name')->where('id', $nota->user_id)->first();
                    return $usuario->name;
                }
            })                                                                  
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="#" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
            ->toJson();
        }
        return view('home');
    }

}
