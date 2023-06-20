<?php

namespace App\Http\Controllers;
use App\User;
use App\Models\Concentrator;
use Illuminate\Http\Request;

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
        return view('notas.concentrators.index');

    }


}
