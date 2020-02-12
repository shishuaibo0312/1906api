<?php

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

Route::get('/phpinfo', function () {
    phpinfo();
});

//测试路由
Route::get('test/redis','Test\TestController@test');
Route::get('testtime','Test\TestController@test2');
//接口路由
Route::prefix('api')->group(function () {
	Route::any('userinfo','Api\UserController@userinfo');
	Route::any('saveuser','Api\UserController@saveuser');
});