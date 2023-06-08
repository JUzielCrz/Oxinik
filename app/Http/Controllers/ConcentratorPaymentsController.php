<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\ConcentratorPayments;


class ConcentratorPaymentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if ($user->permiso_con_admin('concentrator_show')){
            return true;
        }else{
            return view('home');
        };
    }

    function store(Request $request, $note_id){
        $this->slug_permiso();
        
        $payments = new ConcentratorPayments();
        $payments->note_id = $note_id;
        $payments->day = $request->day;
        $payments->price_day = $request->price_day;
        $payments->week = $request->week;
        $payments->price_week = $request->price_week;
        $payments->mount = $request->mount;
        $payments->price_mount = $request->price_mount;
        
        $payments->deposit_garanty = $request->deposit_garanty;
        $payments->date_start = $request->date_start;
        $payments->date_end = $request->date_end;
    
        $payments->total = $request->rent_total;
        $payments->status =  'ADEUDA';
        $payments->user_id = auth()->user()->id;
        $payments->save();

        return $payments;

    }

    function pdf(){
        return false;
    }

    function destroy(ConcentratorPayments $payment_id){
        $payment_id->delete();

    }
}
