<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\NotaPagos;
use App\Models\NotaTanque;
use App\User;
use Illuminate\Http\Request;

class NotaPagosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($nota_id){
            $nota =Nota::where('id',$nota_id)->first();
            $pagos=NotaPagos::where('nota_id',$nota->id)->get();
            $pagos->sum('monto_pago');
            
            $data=['nota'=>$nota, 'pagos'=> $pagos, 'suma_pagos'=>$pagos->sum('monto_pago')];
            return view('notas.pagos.index', $data);
    }

    public function create(Request $request){
            $pago = new NotaPagos();
            $pago->monto_pago = $request->monto_pago;
            $pago->metodo_pago = $request->metodo_pago;
            $pago->nota_id = $request->nota_id;
            $pago->user_id = auth()->user()->id;
            $pago->save();
            
            $notaPagos= NotaPagos::where('nota_id',$request->nota_id);
            $sumpaPagos=$notaPagos->sum('monto_pago');
            $nota=Nota::find($request->nota_id);
            
            if($sumpaPagos >= $nota->total){
                $nota->pago_cubierto = true;
                $nota->save();
            }else{
                return response()->json(['mensaje'=>'Aun con adeudo']);
            }
    }
}
