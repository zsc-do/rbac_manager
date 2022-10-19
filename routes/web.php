<?php

use App\Http\Controllers\sys\LoginController;
use App\Http\Controllers\sys\SysMenuController;
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
    Route::post('doLogin', 'doLogin');
    Route::get('logout', 'logout');


});

Route::controller(SysMenuController::class)->group(function () {

    Route::get('getTreeMenu', 'getTreeMenu');


});


Route::get('/test', function () {

    $hashPassword = HashPasswordUtil::hashPassword('123');

   // echo $hashPassword;

    $checkPassword = HashPasswordUtil::checkPassword($hashPassword);

    echo $checkPassword;

});
