<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user=User::
        join('role_user', 'role_user.user_id', 'users.id')
        ->where('users.id',auth()->user()->id)->first();
        $rol=Role::where('id',$user->role_id)->first();
        $data=['user' => $user, 'rol' => $rol];
        return view('perfil.index', $data);
    }

    public function mis_datos(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(auth()->user()->id, 'id')],
        ]);
        $user=User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->save();
        return response()->json(['mensaje'=>'Actualizado Correctamente','alert'=>'success']);
    }
    public function cambio_email(Request $request){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
            $request->validate([
                'email' => ['required', 'string', 'email','max:255', Rule::unique('users')->ignore($user->id, 'id')],
                'password' => ['required', 'string'],
                ]);
            if (Hash::check($request->password, $user->password)){
                $user->email= $request->email;
                $user->email_verified_at= null;
                if($user->save()){
                    return response()->json(['mensaje'=>'Actualizado Correctamente','useremail' => $user]);
                }
                return response()->json(['mensaje'=>'No Actualizado']);
            }
            $incorrecto='false';
            return response()->json(['mensaje'=>'Contraseña Incorrecta','useremail' => $incorrecto]);
    }

    public function cambio_password(Request $request){
        $idauth=auth()->user()->id;
        $user=User::find($idauth);
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
            if (Hash::check($request->passwordactual, $user->password)){

                $user->password = Hash::make($request->password);

                $user->save();
                return response()->json(['mensaje'=>'Actualizado Correctamente','validpass'=>true]);

            }
            return response()->json(['mensaje'=>'Contraseña Incorrecta', 'validpass'=>false]);
    }

}
