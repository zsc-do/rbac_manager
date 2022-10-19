<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SysRole extends Authenticatable
{

    protected $table = 'sys_role';

    protected $primaryKey = 'role_id';




}
