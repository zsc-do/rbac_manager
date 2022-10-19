<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class SysUser extends Authenticatable
{

    protected $table = 'sys_user';

    protected $primaryKey = 'user_id';


    public function sysRoles()
    {
        return $this->belongsToMany(SysRole::class,'sys_user_role',
            'user_id', 'role_id');
    }
}
