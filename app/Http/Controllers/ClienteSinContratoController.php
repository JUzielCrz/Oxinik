<?php

namespace App\Http\Controllers;

use App\Models\ClienteSinContrato;
use Illuminate\Http\Request;

class ClienteSinContratoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function search(Request $request){
        
        if($request->get('query')){
            $query = $request->get('query');
            $data=ClienteSinContrato::
            where('id', 'LIKE', "%{$query}%")
            ->orWhere('nombre','LIKE', "%{$query}%")
            ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">'; 
            foreach($data as $row) {
                $output .= '<li><a href="#">'.$row->id.', '.$row->nombre.'</a></li>';
            }
            $output .= '</ul>'; 
            echo $output;
        }
    }

    public function show(ClienteSinContrato $id){
        return $id;
    }

    public function create(Request $request){
        $request->validate([
            'tipo_persona' => ['required', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
        ]);
        $nombre_cliente=$request->nombre;
        if($request->tipo_persona=='Fisica'){
            $request->validate([
                'apPaterno' => ['required', 'string', 'max:255'],
                'apMaterno' => ['required', 'string', 'max:255'],
            ]);
            $nombre_cliente=$request->nombre.' '.$request->apPaterno.' '.$request->apMaterno;
        }
        

        $cliente=new ClienteSinContrato();
        $cliente->nombre = $nombre_cliente;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->rfc = $request->rfc;
        $cliente->cfdi = $request->cfdi;
        $cliente->direccion_factura = $request->direccion_factura;
        $cliente->direccion_envio = $request->direccion_envio;
        $cliente->referencia_envio = $request->referencia_envio;
        $cliente->link_ubicacion_envio = $request->link_ubicacion_envio;
        $cliente->precio_envio = $request->precio_envio;
        $cliente->save();
        return response()->json(['cliente_id'=> $cliente->id]);
    }

    public function update(Request $request) {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]); 


        $cliente=ClienteSinContrato::find($request->id);
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->rfc = $request->rfc;
        $cliente->cfdi = $request->cfdi;
        $cliente->direccion_factura = $request->direccion_factura;
        $cliente->direccion_envio = $request->direccion_envio;
        $cliente->referencia_envio = $request->referencia_envio;
        $cliente->link_ubicacion_envio = $request->link_ubicacion_envio;
        $cliente->precio_envio = $request->precio_envio;
        $cliente->save();
        return response()->json(['cliente_id'=> $cliente->id]);
    }
}
