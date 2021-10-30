<?php

namespace App\Models\Traits;

trait UserTrait{

    public function roles(){
        return $this->belongsToMany('App\Role')->withTimestamps();
    }
    //                                'docente'
    public function permiso_con_admin($permission){
        foreach($this->roles as $role){
            if($role['slug']=='admin'){
                return true;
            }
            foreach($role->permissions as $perm){
                if($perm->slug == $permission){
                    return true;
                }
            }
        }
        return false;
    }

    public function permiso_sin_admin($permission){
        foreach($this->roles as $role){
            foreach($role->permissions as $perm){
                if($perm->slug == $permission){
                    return true;
                }
            }
        }
        return false;
    }

    public function soloParaUnRol($rol){

        foreach($this->roles as $role){
            if($role->slug == $rol){
                return true;
            }
        }
        
        return false;
    }

}