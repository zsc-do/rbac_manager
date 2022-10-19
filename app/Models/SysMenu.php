<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SysMenu extends Authenticatable
{
    protected $table = 'sys_menu';

    protected $primaryKey = 'menu_id';


}
