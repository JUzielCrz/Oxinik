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
            'nombre' => ['required', 'string', 'max:255'],
            'apPaterno' => ['required', 'string', 'max:255'],
            'apMaterno' => ['required', 'string', 'max:255'],
        ]);

        $nombre =str_replace(' ', '',$request->nombre);
        $apPaterno =str_replace(' ', '',$request->apPaterno);
        $apMaterno =str_replace(' ', '',$request->apMaterno);

        $cliente=new ClienteSinContrato();
        $cliente->nombre = strtoupper($nombre." ".$apPaterno." ".$apMaterno);
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

    public function update(Request $request){
        $request->validate([
            'nombre_edit' => ['required', 'string', 'max:255'],
            'apPaterno_edit' => ['required', 'string', 'max:255'],
            'apMaterno_edit' => ['required', 'string', 'max:255'],
        ]);

        $nombre =str_replace(' ', '',$request->nombre_edit);
        $apPaterno =str_replace(' ', '',$request->apPaterno_edit);
        $apMaterno =str_replace(' ', '',$request->apMaterno_edit);

        $cliente=ClienteSinContrato::find($request->id_edit);
        $cliente->nombre = strtoupper($nombre." ".$apPaterno." ".$apMaterno);
        $cliente->telefono = $request->telefono_edit;
        $cliente->email = $request->email_edit;
        $cliente->direccion = $request->direccion_edit;
        $cliente->rfc = $request->rfc_edit;
        $cliente->cfdi = $request->cfdi_edit;
        $cliente->direccion_factura = $request->direccion_factura_edit;
        $cliente->direccion_envio = $request->direccion_envio_edit;
        $cliente->referencia_envio = $request->referencia_envio_edit;
        $cliente->link_ubicacion_envio = $request->link_ubicacion_envio_edit;
        $cliente->precio_envio = $request->precio_envio_edit;
        $cliente->save();
        return response()->json(['cliente_id'=> $cliente->id]);
    }
}
