<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permissions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\User;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:50','unique:roles,name'],
            'slug' => ['required', 'max:50','unique:roles,slug'],
        ]);
    }

    protected function validatorupdate(array $data,$id)
    {
        return Validator::make($data, [
            'name' => ['required','max:50', Rule::unique('roles')->ignore($id, 'id')],
            'slug' =>  ['required', 'max:50',Rule::unique('roles')->ignore($id, 'id')],
        ]);
    }

    public function index()
    {
        if($this->slugpermision()){

            $roles= Role::orderby('id', 'desc')->paginate(15);
            $permissions= Permissions::get();
            $data=['roles'=>$roles, 'permissions'=>$permissions];
            return view('roles.index', $data);

        }
        return view('home');
    }

    public function data(){
        if($this->slugpermision()){
            $roles=Role::
            select('roles.*');
            return DataTables::of(
                $roles
            )
            // ->addColumn( 'btnShow', '<button class="btn btn-morado btn-show-modal btn-xs" data-id="{{$id}}"><span class="far fa-eye"></span></button>')
            ->addColumn( 'btnEdit', '<button class="btn btn-grisclaro btn-edit-modal btn-xs" data-id="{{$id}}"><span class="far fa-edit"></span></button>')
            ->addColumn( 'btnDelete', '<button class="btn btn-grisclaro btn-delete-modal btn-xs" data-id="{{$id}}"><span class="fas fa-trash"></span></button>')
            ->rawColumns(['btnShow','btnEdit','btnDelete'])
            ->toJson();
        }
        return view('home');
    }

    
    public function store(Request $request)
    {
        if($this->slugpermision()){

            $this->validator($request->all())->validate();
            
            $roles = new Role;
            $roles->name = $request->input('name');
            $roles->slug = $request->input('slug');
            $roles->description = $request->input('description');

            if($request->get('permission')  ){
                
                if($roles->save() && $roles->permissions()->sync($request->get('permission'))){
                    return response()->json(['mensaje'=>'Registrado Correctamente','rolinsertado' => $roles]);
                }
            }else{
                return response()->json(['mensaje'=>'Debes seleccionar al menos un permiso']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos']);
    }

    public function show($id)
    {   
        if($this->slugpermision()){
            $rol=Role::where('id',$id)->first();
            $permisosroles=Role::join('permissions_role', 'permissions_role.role_id','=','roles.id')
            ->select('permissions_role.permissions_id as permission_id')
            ->where('roles.id',$id)
            ->limit(100)->get();

            $data=['rol'=>$rol,'permisosroles'=>$permisosroles];
            return $data;
        }

        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function update(Request $request, $id)
    {
        if($this->slugpermision()){
        
            $this->validatorupdate($request->all(),$id)->validate();
            
            $roles = Role::find($id);
            $roles->name = $request->name;
            $roles->slug = $request->slug;
            $roles->description = $request->description;

            if($request->get('permission')  ){
                if($roles->save() && $roles->permissions()->sync($request->get('permission'))){
                    return response()->json(['mensaje'=>'Registrado Correctamente','rolactualizado' => $roles]);
                }else{
                    return response()->json(['mensaje'=>'Error al crear Rol']);
                }
            }else{
                return response()->json(['mensaje'=>'Debes seleccionar al menos un permiso', 'rolinsertado' => $roles]);
            }
        }

        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }

    public function destroy(Role $id)
    {
        if($this->slugpermision()){
            if($id->delete()){
                return response()->json(['mensaje'=>'Eliminado Correctamente']);
            }else{
                return response()->json(['mensaje'=>'Error al Eliminar']);
            }
        }
        return response()->json(['mensaje'=>'Sin permisos','accesso'=>'true']);
    }
}

