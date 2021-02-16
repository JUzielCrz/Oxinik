<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\NotaTanque;
use App\Models\Tanque;
use App\User;
use Illuminate\Http\Request;

class PendienteController extends Controller
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

    public function indexgeneral()
    {
        if($this->slugpermision()){
            return view('pendientes.indexgeneral');
        }
        return view('home');
    }


    public function pendientepago(){
        if($this->slugpermision()){
            $notas= Nota::Where('pago_realizado', 'NO' )->orderBy('fecha', 'desc')->get();
            return response()->json(['notas' => $notas]);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function pendientetanques(){
        if($this->slugpermision()){

            $tanques= Tanque::
            select('tanques.num_serie',
            'tanques.estatus',
            )
            ->addSelect(['folioNota' => NotaTanque::select('folio_nota')->whereColumn( 'nota_tanque.num_serie', 'tanques.num_serie')->orderBy('nota_tanque.created_at', 'desc')])
            ->addSelect(['nota_fecha' => Nota::select('fecha')->whereColumn( 'notas.folio_nota', 'folioNota')])
            ->Where('estatus', 'ENTREGADO-CLIENTE' )
            ->orderby('nota_fecha','desc')
            ->get();


            return response()->json(['tanques' => $tanques]);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }



}