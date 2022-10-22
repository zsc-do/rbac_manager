<?php

namespace App\Http\Controllers\sys;

use App\Models\SysRole;
use App\Models\SysUser;
use App\util\AuthPermissionUtil;
use App\util\HashPasswordUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SysUserController
{

    public function userView(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:view',$userId)){
            echo "没有权限";
            return;
        };

        return view('sys.user.user-list');
    }



    public function userList(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:list',$userId)){
            echo "没有权限";
            return;
        };


        $perPage = $request->input('perPage');


        $users = Sysuser::paginate($perPage);;

        return response()->json($users);
    }






    public function userAddPage(Request $request){
        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:add',$userId)){
            echo "没有权限";
            return;
        };


        return view('sys.user.user-add');
    }

    public function userAdd(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:add',$userId)){
            echo "没有权限";
            return;
        };

        $userName = $request->input('userName');
        $password= $request->input('password');
        $phone= $request->input('phone');
        $gender= $request->input('gender');

        $selectedRoleIds= $request->input('selectedRoles');
        $selectedRoleIds = explode(',', $selectedRoleIds);


        $hashPassword = HashPasswordUtil::hashPassword($password);

        $userId = DB::table('sys_user')->insertGetId([
            'user_name' => $userName,
            'password' => $hashPassword,
            'phone' => $phone,
            'gender' => $gender,
        ]);


        foreach ($selectedRoleIds as $selectedRoleId){
            DB::table('sys_user_role')->insert([
                'user_id' => $userId,
                'role_id' => $selectedRoleId
            ]);
        }
    }


    public function userEditPage(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:edit',$userId)){
            echo "没有权限";
            return;
        };



        return view('sys.user.user-edit');
    }


    public function userEdit(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:edit',$userId)){
            echo "没有权限";
            return;
        };

        $userId = $request->input('userId');
        $userName = $request->input('userName');
        $password= $request->input('password');
        $phone= $request->input('phone');
        $gender= $request->input('gender');


        $selectedRoleIds= $request->input('selectedRoles');
        $selectedRoleIds = explode(',', $selectedRoleIds);

        $hashPassword = HashPasswordUtil::hashPassword($password);

        DB::table('sys_user')->where('user_id', $userId)->update([
            'user_name' => $userName,
            'password' => $hashPassword,
            'phone' => $phone,
            'gender' => $gender,
        ]);

        DB::table('sys_user_role')->where('user_id', $userId)->delete();

        foreach ($selectedRoleIds as $selectedRoleId){
            DB::table('sys_user_role')->insert([
                'user_id' => $userId,
                'role_id' => $selectedRoleId
            ]);
        }

    }



    public function userRemove(Request $request){

        $userId = $request->session()->get('userId');

        if (!AuthPermissionUtil::AuthPermission('system:user:remove',$userId)){
            echo "没有权限";
            return;
        };

        $userId = $request->input('userId');

        DB::table('sys_user')->where('user_id', '=', $userId)->delete();

        DB::table('sys_user_role')->where('user_id', '=', $userId)->delete();

    }


    public function getUser(Request $request){
        $userId = $request->input('userId');

        $user = SysUser::where('user_id', $userId)->get();

        return response()->json($user);
    }




}
