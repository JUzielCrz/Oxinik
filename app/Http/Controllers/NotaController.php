<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Nota;
use App\Models\Notas;
use App\Models\NotaTanque;
use App\Models\Tanque;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        return $user->havePermission('contratos');
    }
    
    public function index($num_contrato)
    {
        if($this->slugpermision()){
            $contrato = Contrato::where('num_contrato',$num_contrato)->first();
            $cliente = Cliente:: select('apPaterno','apMaterno','nombre')->where('id', $contrato->cliente_id)->first();
            $data = ['contrato'=>$contrato, 'cliente'=>$cliente];
            return view( 'notas.index', $data);
        }
        return view('home');
    }

    public function datatablesindex($numContrato){
        if($this->slugpermision()){
            $notas=Nota::
            select('notas.*')->where('num_contrato',$numContrato);
            return DataTables::of(
                $notas
            )
            ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$folio_nota}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$folio_nota}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$folio_nota}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }



    public function newnota($numContrato){
        if($this->slugpermision()){
            $data = ['numContrato'=>$numContrato];
            return view( 'notas.newnota', $data);
        }
        return view('home');
    }

    public function insertfila($serietanque){
        if($this->slugpermision()){
            if($tanques=Tanque::where('num_serie',$serietanque)->first() ){
                return response()->json(['tanque' => $tanques, 'alert' => true]);
            }
            return response()->json(['tanque' => $tanques, 'alert' => false]);
        }
        return view('home');
    }



    public function create(Request $request)
    {        
        if($this->slugpermision()){
            $request->validate([
                'folio_nota' => ['required', 'string', 'max:255', 'unique:notas,folio_nota'],
                'fecha' => ['required'],
                'pago_realizado' => ['required', 'string', 'max:255'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'num_contrato' => ['required', 'string', 'max:255'],
            ]);

            if(count($request->inputNumSerie) > 0){

                $notas=new Nota;
                $notas->folio_nota = $request->input('folio_nota');
                $notas->fecha = $request->input('fecha');
                $notas->metodo_pago = $request->input('metodo_pago');
                $notas->pago_realizado = $request->input('pago_realizado');
                $notas->num_contrato = $request->input('num_contrato');
                if($notas->save()){
                    foreach( $request->inputNumSerie AS $series => $g){
                        $notaTanque=new NotaTanque;
                        $notaTanque->folio_nota = $request->input('folio_nota');
                        $notaTanque->num_serie = $request->inputNumSerie[$series];
                        $notaTanque->precio = $request->inputPrecio[$series];
                        $notaTanque->regulador = $request->inputRegulador[$series];
                        $notaTanque->tapa_tanque = $request->inputTapa[$series];
                        $notaTanque->save();
                    }
                    
                }
            }

            return response()->json(['mensaje'=>'Registrado Correctamente']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function editnota($folionota){
        if($this->slugpermision()){
            $notas= Nota::where('folio_nota',$folionota)->first();

            $notasTanques= NotaTanque:: 
            join('tanques', 'tanques.num_serie','nota_tanque.num_serie')
            ->where('folio_nota', $notas->folio_nota)->get();

            $data=['notas'=>$notas, 'notasTanques' =>$notasTanques ];
            return view('notas.edit',$data );
        }
    }

    public function update(Request $request , $idNota)
    {        
        if($this->slugpermision()){

            $request->validate([
                'folio_nota' => ['required', 'string','max:255', Rule::unique('notas')->ignore($idNota, 'id')],
                'fecha' => ['required'],
                'pago_realizado' => ['required', 'string', 'max:255'],
                'metodo_pago' => ['required', 'string', 'max:255'],
                'num_contrato' => ['required', 'string', 'max:255'],
            ]);

            if(count($request->inputNumSerie) > 0){

                $notas=Nota::find($idNota);
                $notaTanque=NotaTanque::where('folio_nota',$notas->folio_nota);
                $notaTanque->delete();

                $notas->folio_nota = $request->input('folio_nota');
                $notas->fecha = $request->input('fecha');
                $notas->metodo_pago = $request->input('metodo_pago');
                $notas->pago_realizado = $request->input('pago_realizado');
                $notas->num_contrato = $request->input('num_contrato');

                if($notas->save()){
                    foreach( $request->inputNumSerie AS $series => $g){
                        $notaTanque=new NotaTanque;
                        $notaTanque->folio_nota = $request->input('folio_nota');
                        $notaTanque->num_serie = $request->inputNumSerie[$series];
                        $notaTanque->precio = $request->inputPrecio[$series];
                        $notaTanque->regulador = $request->inputRegulador[$series];
                        $notaTanque->tapa_tanque = $request->inputTapa[$series];
                        $notaTanque->save();
                    }
                    
                }
            }

            return response()->json(['mensaje'=>'Registrado Correctamente']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }


    public function destroy($folioNota){
        if($this->slugpermision()){
            $nota= Nota::where('folio_nota', $folioNota)->first();
            $tanqueNota= NotaTanque::where('folio_nota', $nota->folio_nota);
            if($tanqueNota->delete()){
                if($nota->delete()){
                    return response()->json(['mensaje'=>'Eliminado Correctamente']);
                }
            }
            else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

}
