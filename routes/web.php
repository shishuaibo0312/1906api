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
Route::any('test3','Test\TestController@test3');
Route::any('test4','Test\TestController@test4');
Route::any('test5','Test\TestController@test5');
Route::any('test6','Test\TestController@test6');
Route::any('test7','Test\TestController@test7');
Route::any('test8','Test\TestController@test8');
Route::any('test9','Test\TestController@test9');
Route::any('test10','Test\TestController@test10');
//测试访问量
Route::any('goods','Test\GoodsController@goods');	
Route::prefix('api')->group(function () {
	Route::any('userinfo','Api\UserController@userinfo');
	Route::any('saveuser','Api\UserController@saveuser');
});