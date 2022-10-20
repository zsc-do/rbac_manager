<?php

use App\Http\Controllers\sys\LoginController;
use App\Http\Controllers\sys\SysMenuController;
use App\Http\Controllers\sys\SysRoleController;
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

    Route::get('/sys/getTreeMenu', 'getTreeMenu');
    Route::get('/sys/menuView', 'menuView');
    Route::get('/sys/menuList', 'menuList');

    Route::get('/sys/getAllML', 'getAllML');
    Route::get('/sys/getAllCD', 'getAllCD');
    Route::get('/sys/getMenu', 'getMenu');

    Route::get('/sys/menuAddPage', 'menuAddPage');
    Route::post('/sys/menuAdd', 'menuAdd');

    Route::get('/sys/menuEditPage', 'menuEditPage');
    Route::post('/sys/menuEdit', 'menuEdit');

    Route::get('/sys/menuRemove', 'menuRemove');



});


Route::controller(SysRoleController::class)->group(function () {

    Route::get('/sys/role/View', 'roleView');
    Route::get('/sys/roleList', 'roleList');
    Route::get('/sys/getRole', 'getRole');


    Route::get('/sys/roleAddPage', 'roleAddPage');
    Route::post('/sys/roleAdd', 'roleAdd');

    Route::get('/sys/roleEditPage', 'roleEditPage');
    Route::post('/sys/roleEdit', 'roleEdit');

    Route::get('/sys/roleRemove', 'roleRemove');



});


Route::get('/test', function () {

    $hashPassword = HashPasswordUtil::hashPassword('123');

   // echo $hashPassword;

    $checkPassword = HashPasswordUtil::checkPassword($hashPassword);

    echo $checkPassword;

});
