<?php

namespace App\Http\Controllers\sys;

use App\Models\SysMenu;
use App\Models\SysRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SysRoleController
{

    public function roleView(){
        return view('sys.role.role-list');
    }


    public function roleList(){
        $roles = SysRole::all();

        return response()->json($roles);
    }


    public function roleAddPage(){
        return view('sys.role.role-add');
    }


    public function roleAdd(Request $request){
        $roleName = $request->input('roleName');
        $remark = $request->input('remark');

        $checkedMenuIds = $request->input('checkedMenus');

        $checkedMenuIds = str_replace('[','',$checkedMenuIds);
        $checkedMenuIds = str_replace(']','',$checkedMenuIds);

        $checkedMenuIds = explode(',', $checkedMenuIds);


        //dd($checkedMenuIds);

        $roleId = DB::table('sys_role')->insertGetId([
            'role_name' => $roleName,
            'remark' => $remark
        ]);


        foreach ($checkedMenuIds as $checkedMenuId){
            DB::table('sys_role_menu')->insert([
                'role_id' => $roleId,
                'menu_id' => $checkedMenuId
            ]);
        }
    }


    public function roleEditPage(){
        return view('sys.role.role-edit');
    }





    public function roleEdit(Request $request){
        $roleId = $request->input('roleId');
        $roleName = $request->input('roleName');
        $remark = $request->input('remark');


        $checkedMenuIds = $request->input('checkedMenus');

        $checkedMenuIds = str_replace('[','',$checkedMenuIds);
        $checkedMenuIds = str_replace(']','',$checkedMenuIds);

        $checkedMenuIds = explode(',', $checkedMenuIds);



        DB::table('sys_role')->where('role_id', $roleId)->update([
            'role_name' => $roleName,
            'remark' => $remark,
        ]);

        DB::table('sys_role_menu')->where('role_id', $roleId)->delete();


        foreach ($checkedMenuIds as $checkedMenuId){
            DB::table('sys_role_menu')->insert([
                'role_id' => $roleId,
                'menu_id' => $checkedMenuId
            ]);
        }

    }


    public function roleRemove(Request $request){
        $roleId = $request->input('roleId');

        DB::table('sys_role')->where('role_id', '=', $roleId)->delete();

        DB::table('sys_role_menu')->where('role_id', '=', $roleId)->delete();

    }



    public function getRole(Request $request){
        $roleId = $request->input('roleId');

        $role = SysRole::where('role_id', $roleId)->get();

        return response()->json($role);
    }

}
