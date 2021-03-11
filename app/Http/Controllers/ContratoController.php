<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
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
    
    protected function validatorupdate(array $data,$id)
    {
        return Validator::make($data, [
            'num_contrato' => ['required','max:50', Rule::unique('contratos')->ignore($id, 'id')],
            'cliente_id' => ['required'],
            'tipo_contrato' => ['required', 'string', 'max:255'],
            'precio_transporte' => ['required', 'string', 'max:255'],
        ]);
    }


    public function index($id)
    {
        if($this->slugpermision()){
            $cliente = Cliente::where('id',$id)->first();
            $contratos=Contrato::select('contratos.*')->where('contratos.cliente_id',$id)->get();
            $data = ['cliente'=> $cliente, 'contratos'=>$contratos];
            return view('contratos.index', $data);
        }
        return view('home');
    }


    public function create(Request $request)
    {
        if($this->slugpermision()){
            $request->validate([
                'num_contrato' => ['required', 'string', 'max:255', 'unique:contratos,num_contrato'],
                'cliente_id' => ['required'],
                'tipo_contrato' => ['required', 'string', 'max:255'],
                'precio_transporte' => ['required', 'string', 'max:255'],
                'asignacion_tanques' => ['required', 'string', 'max:255'],
            ]);

            $contratos=new Contrato;
            $contratos->num_contrato = $request->input('num_contrato');
            $contratos->cliente_id = $request->input('cliente_id');
            $contratos->tipo_contrato = $request->input('tipo_contrato');
            $contratos->asignacion_tanques = $request->input('asignacion_tanques');
            $contratos->precio_transporte = $request->input('precio_transporte');

            if($contratos->save()){
                return response()->json(['mensaje'=>'Registrado Correctamente', 'contratos'=>$contratos]);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show($num_contrato)
    {
        if($this->slugpermision()){
            $contrato=Contrato::where('num_contrato',$num_contrato)->first();
            $data=['contratos'=>$contrato];
            return $data;
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function update(Request $request, $id)
    {
        if($this->slugpermision()){

            $this->validatorupdate($request->all(),$id)->validate();


            $contratos = Contrato::find($id);
            $contratos->num_contrato = $request->num_contrato;
            $contratos->cliente_id = $request->cliente_id;
            $contratos->tipo_contrato = $request->tipo_contrato;;
            $contratos->precio_transporte = $request->precio_transporte;
            $contratos->direccion = $request->direccion;
            $contratos->referencia = $request->referencia;

            if($contratos->save()){
                    return response()->json(['mensaje'=>'Editado Correctamente', 'contratos'=>$contratos]);
            }
            return response()->json(['mensaje'=>'Error, Verifica tus datos']);

        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function destroy(Contrato $id)
    {
        if($this->slugpermision()){
            if($id->delete()){
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }
            return response()->json(['mensaje'=>'Error al Eliminar']);
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);

    }

}
