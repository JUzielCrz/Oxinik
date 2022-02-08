<?php

namespace App\Http\Controllers;

use App\Models\DatosEmpresa;
use App\User;
use Illuminate\Http\Request;

class ConfigSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function slugpermision(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
        return $user->soloParaUnRol('admin');
    }
    public function empresa_index(){
        if($this->slugpermision()){
            $empresa=DatosEmpresa::find(1);
            return view('config_system.empresa_index', compact('empresa'));
        }
        return view('home');
        
    }


    public function empresa_save(Request $request){
        if($this->slugpermision()){
            $empresa=DatosEmpresa::find(1);
            $empresa->email=$request->email;
            $empresa->rfc=$request->rfc;
            $empresa->direccion=$request->direccion;
            $empresa->telefono1=$request->telefono1;
            $empresa->telefono2=$request->telefono2;
            $empresa->telefono3=$request->telefono3;
            $empresa->num_cuenta1=$request->num_cuenta1;
            $empresa->clave1=$request->clave1;
            $empresa->banco1=$request->banco1;
            $empresa->titular1=$request->titular1;
            $empresa->num_cuenta2=$request->num_cuenta2;
            $empresa->clave2=$request->clave2;
            $empresa->banco2=$request->banco2;
            $empresa->titular2=$request->titular2;
            $empresa->save();
        }
        return response()->json(['alert'=>'Sin Permisos']);
    }

}
