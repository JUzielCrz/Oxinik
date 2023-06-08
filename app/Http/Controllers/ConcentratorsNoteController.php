<?php

namespace App\Http\Controllers;
use App\User;
use App\Models\Concentrator;
use App\Models\ConcentratorNote;
use App\Models\ClienteSinContrato;
use App\Models\ConcentratorPayments;
use App\Models\DatosEmpresa;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;


class ConcentratorsNoteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if ($user->permiso_con_admin('drivers_show')){
            return true;
        }else{
            return view('home');
        };
    }

    public function index(){
        $this->slug_permiso();
        return view('concentrator.listNotes');
    }

    public function data(){

        $this->slug_permiso();
            $notes=ConcentratorNote::all();
            return DataTables::of(
                $notes
            )                                                               
            ->editColumn('user_name', function ($nota) {
                if($nota->user_id == null){
                    return null;
                }else{
                    $usuario = User::select('name')->where('id', $nota->user_id)->first();
                    return $usuario->name;
                }
            })
            ->editColumn('created_at', function ($infra) {
                return $infra->created_at->format('Y/m/d - H:i:s A');
            })
            ->addColumn( 'buttons', 
                '<a class="btn btn-sm btn-verde btn-xs" target="_blank" href="{{route(\'concentrator.note.pdf\', $id)}}" title="Nota"><i class="fas fa-file-pdf"></i></a>'.
                '<a class="btn btn-sm btn-verde btn-xs mx-2" href="{{route(\'concentrator.note.edit\', $id)}}" title="Nota"><i class="fas fa-edit"></i></a>'.
                '<button class="btn btn-sm btn-verde btn-cancelar" data-id="{{$id}}" title="Cancelar"><span class="fas fa-trash"></span></button>'
            )
            ->rawColumns(['buttons'])
            ->toJson();
    }

    public function note_create(){
        $this->slug_permiso();
        return view('concentrator.note.create');
    }

    public function store(Request $request)
    {

            $concentrator = Concentrator::where('serial_number', $request->serial_number)->first();
            $cliente = ClienteSinContrato::find( $request->id_show );
    
            $note = new ConcentratorNote();
            $note->num_client = $cliente->id;
            $note->name = $cliente->nombre;
            $note->phone_number = $cliente->telefono;
            $note->email = $cliente->email;
            $note->address = $cliente->direccion;
            $note->rfc = $cliente->rfc;
            $note->cfdi = $cliente->cfdi;
            $note->address_facture = $cliente->direccion_factura;
    
            $note->concentrator_id = $concentrator->id;
            $note->user_id = auth()->user()->id;
            $note->observations = $request->observaciones;
            $note->save();
    
            $payments = new ConcentratorPayments();
            $payments->note_id = $note->id;
            $payments->day = $request->day;
            $payments->price_day = $request->price_day;
            $payments->week = $request->week;
            $payments->price_week = $request->price_week;
            $payments->mount = $request->mount;
            $payments->price_mount = $request->price_mount;
            
            $payments->deposit_garanty = $request->deposit_garanty;
            $payments->date_start = $request->date_start;
            $payments->date_end = $request->date_end;
    
            $payments->total = $request->total;
            $payments->payment_method = $request->payment_method;
            $payments->status =  'PAGADO';
    
            $payments->user_id = auth()->user()->id;
            $payments->save();
    
            $concentrator->status= 'EN RENTA';
            $concentrator->save();
            return response()->json(['note_id'=> $note->id,  ]);
        

    }

    public function pdf($note_id){
        $note=ConcentratorNote::find($note_id);
        $payment=ConcentratorPayments::
        join('concentrator_notas', 'concentrator_notas.id','=','concentrator_payments.note_id' )
        ->where('note_id', $note_id)
        ->orderBy('concentrator_payments.id', 'asc')->first();
        $empresa=DatosEmpresa::find(1);

        $data=['note'=>$note, 'payment'=>$payment, 'empresa'=>$empresa];
        $pdf = PDF::loadView('concentrator.note.pdf', $data);
    
        return $pdf->stream('nota_talon_'.$note->id.'.pdf');
        // return $pdf->dowload('name.pdf');
    }

    public function note_edit($id){
        $this->slug_permiso();
        $note = ConcentratorNote::find($id);
        $concentrator = Concentrator::find($note->concentrator_id);
        $payments = ConcentratorPayments::where('note_id',$note->id)->get();

        return view('concentrator.note.edit.index', compact('note', 'concentrator', 'payments'));
    }


}
