<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    protected function validatorupdate(array $data,$id)
    {
        return Validator::make($data, [
            'name' => ['required','max:50', Rule::unique('users')->ignore($id, 'id')],
            'email' =>  ['required', 'max:50',Rule::unique('users')->ignore($id, 'id')]

        ]);
    }

    public function index()
    {
        if($this->slugpermision()){

            $users= User::with('roles')->orderby('id', 'desc')->paginate(15);
            $roles = Role::pluck('name','id');

            $data=['users'=>$users, 'roles'=>$roles];
            return view('usuarios.index', $data);

        }
        return view('home');
    }

    public function data(){
        if($this->slugpermision()){
            $usuario=User::
            select('users.*');
            return DataTables::of(
                $usuario
            )
            ->addColumn( 'btnShow', '<button class="btn btn-sm btn-verde btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-sm btn-verde btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-sm btn-verde btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }

    public function create(Request $request){
        
        if($this->slugpermision()){
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255','unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $passwordgenerate='cedart'.rand(999, 9999);

            $users=new User;
            $users->name = $request->input('name');
            $users->email = $request->input('email');
            $users->password = Hash::make($request->input('password'));
            
            if($request->get('roleid')){
                if($users->save() && $users->roles()->sync($request->get('roleid'))){
                        return response()->json(['mensaje'=>'Registrado Correctamente']);
                }else{
                    return response()->json(['mensaje'=>'No registrado']);
                }
            }else{
                return response()->json(['mensaje'=>'Debes seleccionar al menos un rol']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);
        
    }

    public function show(User $id)
    {
        if($this->slugpermision()){
            
            $rolid = User::join('role_user','role_user.user_id','=','users.id')
            ->where('role_user.user_id', $id->id)->pluck('role_user.role_id');

            $data=['user'=>$id,'rolid'=>$rolid];
            return $data;

            
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function update(Request $request, $id)
    {
        $slug='usuarios.edit'; 
        if($this->slugpermision($slug)){

            $this->validatorupdate($request->all(),$id)->validate();

            $users = User::find($id);
            $users->name = $request->name;
            $users->email = $request->email;

            $rolactualizado=Role::where('id', $request->roles)->pluck('name');

            if($request->get('roles')){
                if($users->save() && $users->roles()->sync($request->get('roles'))){
                    return response()->json(['mensaje'=>'Editado Correctamente','useractualizado' => $users, 'rolactualizado'=>$rolactualizado]);
                }else{
                    return response()->json(['mensaje'=>'Error al editar Usuario']);
                }
            }else{
                return response()->json(['mensaje'=>'Debes seleccionar un Rol']);
            }
        }

        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }


    public function destroy(User $id)
    {
        $slug='usuarios.destroy'; 
        if($this->slugpermision($slug)){

            if($id->delete()){

                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }else{

                return response()->json(['mensaje'=>'Error al Eliminar']);

            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }
}
