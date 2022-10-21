<?php

namespace App\util;

use App\Models\SysRole;
use App\Models\SysUser;

class AuthPermissionUtil
{


    public static function AuthPermission($permission,$userId){

        $roles = SysUser::find($userId)->sysRoles()->get();


        foreach ($roles as $role){
            $menus = SysRole::find($role->role_id)->sysMenus()->get();

            foreach ($menus as $menu){
                if ($menu->menu_perms === $permission){
                    return true;
                }
            }
        }

        return false;

    }

}
