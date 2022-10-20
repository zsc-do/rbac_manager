<?php

use App\Http\Controllers\sys\LoginController;
use App\Http\Controllers\sys\SysMenuController;
use App\Http\Controllers\sys\SysRoleController;
use App\Http\Controllers\sys\SysUserController;
use App\Models\SysUser;
use App\util\HashPasswordUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(LoginController::class)->group(function () {

    Route::get('/login', 'login')->name('login');
    Route::post('/doLogin', 'doLogin');
    Route::get('/logout', 'logout');


});

Route::controller(SysMenuController::class)->group(function () {

    Route::get('/sys/menu/getTreeMenu', 'getTreeMenu');
    Route::get('/sys/menu/menuView', 'menuView');
    Route::get('/sys/menu/menuList', 'menuList');

    Route::get('/sys/menu/getAllML', 'getAllML');
    Route::get('/sys/menu/getAllCD', 'getAllCD');
    Route::get('/sys/menu/getMenu', 'getMenu');

    Route::get('/sys/menu/menuAddPage', 'menuAddPage');
    Route::post('/sys/menu/menuAdd', 'menuAdd');

    Route::get('/sys/menu/menuEditPage', 'menuEditPage');
    Route::post('/sys/menu/menuEdit', 'menuEdit');

    Route::get('/sys/menu/menuRemove', 'menuRemove');



});


Route::controller(SysRoleController::class)->group(function () {

    Route::get('/sys/role/roleView', 'roleView');
    Route::get('/sys/role/roleList', 'roleList');
    Route::get('/sys/role/getRole', 'getRole');


    Route::get('/sys/role/roleAddPage', 'roleAddPage');
    Route::post('/sys/role/roleAdd', 'roleAdd');

    Route::get('/sys/role/roleEditPage', 'roleEditPage');
    Route::post('/sys/role/roleEdit', 'roleEdit');

    Route::get('/sys/role/roleRemove', 'roleRemove');
});



Route::controller(SysUserController::class)->group(function () {

    Route::get('/sys/user/userView', 'userView');
    Route::get('/sys/user/userList', 'userList');
    Route::get('/sys/user/getUser', 'getUser');


    Route::get('/sys/user/userAddPage', 'userAddPage');
    Route::post('/sys/user/userAdd', 'userAdd');

    Route::get('/sys/user/userEditPage', 'userEditPage');
    Route::post('/sys/user/userEdit', 'userEdit');

    Route::get('/sys/user/userRemove', 'userRemove');



});

Route::get('/test', function () {

    $hashPassword = HashPasswordUtil::hashPassword('123');

   // echo $hashPassword;

    $checkPassword = HashPasswordUtil::checkPassword($hashPassword);

    echo $checkPassword;

});
