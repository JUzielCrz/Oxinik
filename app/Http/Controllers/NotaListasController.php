<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\NotaEntrada;
use App\Models\VentaExporadica;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use App\User;

class NotaListasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('clientes');
    }


    public function index(){
        if($this->slugpermision()){
            return view('notas.listas.index');
        }
        return view('home');
    }

    public function salidas_data(){
        if($this->slugpermision()){
            $nota_entrada=Nota::
            join('contratos','contratos.id','=','notas.contrato_id')
            ->select('notas.id as nota_id',
                    'contratos.num_contrato',
                    'notas.fecha',
                    'notas.pago_cubierto',
                    'notas.observaciones');
            return DataTables::of(
                $nota_entrada
            )                                                               
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-grisclaro btn-xs" target="_blank" href="{{route(\'pdf.nota_salida\', $nota_id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
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

    public function exporadica_data(){
        if($this->slugpermision()){
            $nota_entrada=VentaExporadica::all();
            return DataTables::of(
                $nota_entrada
            )                                                               
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-grisclaro btn-xs" target="_blank" href="{{route(\'pdf.nota_exporadica\', $id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
            ->toJson();
        }
        return view('home');
    }

    public function adeudos_data(){
        if($this->slugpermision()){
            $nota_entrada=Nota::
            join('contratos','contratos.id','=','notas.contrato_id')
            ->select('notas.id as nota_id',
                    'contratos.num_contrato',
                    'notas.fecha',
                    'notas.pago_cubierto',
                    'notas.observaciones')
            ->where('notas.pago_cubierto', false);
            return DataTables::of(
                $nota_entrada
            )                                                             
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-grisclaro btn-xs" target="_blank" href="{{route(\'pdf.nota_salida\', $nota_id)}}" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
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
        if($this->slugpermision()){
            $nota_entrada=NotaEntrada::
            join('contratos','contratos.id','=','notas_entrada.contrato_id')
            ->select('notas_entrada.id as nota_id',
                    'contratos.num_contrato',
                    'notas_entrada.*',);
            return DataTables::of(
                $nota_entrada
            )                                                               
            ->addColumn( 'btnNota', '<a class="btn btn-sm btn-grisclaro btn-xs" target="_blank" href="#" title="Nota"><i class="fas fa-sticky-note"></i></a>')
            ->rawColumns(['btnNota'])
            ->toJson();
        }
        return view('home');
    }

}
