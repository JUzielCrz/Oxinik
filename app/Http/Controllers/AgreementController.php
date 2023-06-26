<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\CatalogoGas;

class AgreementController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function slug_permiso(){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);

        if ($user->permiso_con_admin('agreement_show')){
            return true;
        }else{
            return view('home');
        };
    }

    public function create($client_id){
        $client = Cliente::find($client_id);
        $gases = CatalogoGas::all();    
        $this->slug_permiso();
        $data=["client" => $client, "gases" => $gases];
        return view('agreement.create', $data);
    }
}
