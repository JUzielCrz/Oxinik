<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\ConcentratorPayments;
use App\Models\ConcentratorNote;
use App\Models\DatosEmpresa;
use Barryvdh\DomPDF\Facade as PDF;


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

    public function pdf($note_id, $payment_id){
        $note=ConcentratorNote::find($note_id);
        $payment=ConcentratorPayments::find($payment_id);
        $empresa=DatosEmpresa::find(1);

        $data=['note'=>$note, 'payment'=>$payment, 'empresa'=>$empresa];
        if($payment->work_hours_output === null){
            $pdf = PDF::loadView('concentrator.note.edit.payments.pdf', $data);
        }else{
            $pdf = PDF::loadView('concentrator.note.pdf', $data);
        }

        return $pdf->stream('nota_talon_'.$note->id.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    function destroy(ConcentratorPayments $payment_id){
        $payment_id->delete();

    }

    function update_pay(Request $request, ConcentratorPayments $payment_id){
        if($payment_id->status == 'PAGADO'){
            return response()->json([
                'title' => 'Error',
                'message' => 'Este pago ya se registro anteriormente',
                'type' => 'warning',
            ]);
        }else{
            $payment_id->status = 'PAGADO';
            $payment_id->payment_method = $request->payment_method;
            $payment_id->save();
            return response()->json([
                'title' => 'Exito',
                'message' => 'Guardado Correctamente',
                'type' => 'success',
            ]);
        }
    }
}
