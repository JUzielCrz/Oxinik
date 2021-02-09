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

    public function indexgeneral()
    {
        if($this->slugpermision()){
            return view('contratos.indexgeneral');
        }
        return view('home');
    }

    public function datatablesindexgeneral(){
        if($this->slugpermision()){
            $contratos=Contrato::
            join('clientes', 'clientes.id','=','contratos.cliente_id')
            ->select('contratos.*',
                    DB::raw("CONCAT(apPaterno,' ',apMaterno,' ',nombre) AS nombrecliente"),
                    );
            return DataTables::of(
                $contratos
            )
            ->addColumn( 'btnNota', '<a class="btn btn-grisclaro btn-xs" href="{{route(\'nota.index\', $num_contrato)}}"><span class="fas fa-clipboard"></span></a>')
            ->addColumn( 'btnEdit', '<button class="btn btn-naranja btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-amarillo btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnNota','btnEdit','btnDelete'])
            ->toJson();
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
                // 'precio_definido' => ['required', 'string', 'max:255'],
                'precio_transporte' => ['required', 'string', 'max:255'],
            ]);

            $contratos=new Contrato;
            $contratos->num_contrato = $request->input('num_contrato');
            $contratos->cliente_id = $request->input('cliente_id');
            $contratos->tipo_contrato = $request->input('tipo_contrato');
            // $contratos->precio_definido = $request->input('precio_definido');
            $contratos->precio_transporte = $request->input('precio_transporte');

            if($contratos->save()){
                return response()->json(['mensaje'=>'Registrado Correctamente', 'contratos'=>$contratos]);
            }
            return response()->json(['mensaje'=>'No registrado']);
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show(Contrato $id)
    {
        if($this->slugpermision()){
            $data=['contratos'=>$id];
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
            $contratos->tipo_contrato = $request->tipo_contrato;
            $contratos->precio_transporte = $request->precio_transporte;

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
