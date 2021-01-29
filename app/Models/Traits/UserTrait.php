<?php

namespace App\Models\Traits;

trait UserTrait{

    public function roles(){
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function havePermission($permission){
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

    public function permissionsinFull($permission){

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