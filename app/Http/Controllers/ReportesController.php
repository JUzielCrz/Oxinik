<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->havePermission('tanques');
    }



    public function index()
    {
        if($this->slugpermision()){
            $vacioalmacen= Tanque::where('estatus','VACIO-ALMACEN'); //analizar
            $llenoalmacen= Tanque::where('estatus','LLENO-ALMACEN');
            $entregadocliente= Tanque::where('estatus','ENTREGADO-CLIENTE');
            $infra= Tanque::where('estatus','INFRA');
            $mantenimiento= Tanque::where('estatus','MANTENIMIENTO');

            $cantEntregadoCliente= $entregadocliente->count();
            $cantllenoalmacen= $llenoalmacen->count();
            $cantvacioalmacen= $vacioalmacen->count();
            $cantinfra= $infra->count();
            $cantmantenimiento= $mantenimiento->count();
            
            $data=['cantEntregadoCliente'=>$cantEntregadoCliente, 
            'cantllenoalmacen'=>$cantllenoalmacen, 
            'cantvacioalmacen'=>$cantvacioalmacen,
            'cantinfra'=>$cantinfra,
            'cantmantenimiento'=>$cantmantenimiento];
            return view('reportes.index', $data);
        }
        return view('home');
    }


    public function dt_listtanques( $estatus){

        if($this->slugpermision()){
            $tanques=Tanque::
            select('tanques.*')->where('estatus', $estatus);

            return DataTables::of(
                $tanques
            )
            ->toJson();
        }
        return view('home');
    }
}
