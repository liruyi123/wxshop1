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

Route::get('/hello', function () {
    return 'hello aaa';
});
Route::get('/form', function () {
    return '<form action="/foo" method="post"> '.csrf_field().'<input type="text" name="aaa"/> <button>提交</button>';
});
Route::post('/foo', function () {
    return 'hello aaa';
});
//重定向
Route::redirect('/aaa','/',301);
//路由视图

//Route::get('/he', function () {
//    return view('test');
//});
//Route::view('/he','test',['name'=>'zhangsan']);
//路由参数
//Route::get('/he/{id}', function ($id) {
//    return 'id 是：'.$id;
//});

Route::get('/he/{id}','UserController@index');
