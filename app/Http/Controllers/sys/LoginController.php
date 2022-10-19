<?php

namespace App\Http\Controllers\sys;

use App\Models\SysUser;
use App\util\HashPasswordUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{

    public function login(){
        return view('login');
    }


    public function doLogin(Request $request){
        $username = $request->input('username');

        $password = $request->input('password');

        $hashPassword = HashPasswordUtil::hashPassword($password);
        $sysUser = SysUser::where('user_name', $username)->first();

        if (HashPasswordUtil::checkPassword($password, $sysUser->password)){
            return view('index');
        }else{
            return view('login');
        };

    }



    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
