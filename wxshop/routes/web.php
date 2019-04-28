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

Route::get('/','IndexController@index' );
//商品路由
route::prefix('goods')->group(function(){
    Route::any('goodslist/{id?}','Goods\GoodsController@goodslist' );
    Route::any('add','Goods\GoodsController@add' );
    //商品详情
    Route::get('shopcontent/{id}','Goods\GoodsController@shopcontent' );
});
Route::get('show','Goods\GoodsController@show' );
//购物车路由
route::prefix('cart')->group(function(){
    //展示页面
   route::get('shopcart','Cart\CartController@shopcart');
   //加入购物车
    route::post('cartNum','Cart\CartController@cartNum');
    //点击加号
    route::post('cartBuyNum','Cart\CartController@cartBuyNum');
    //点击删除
    route::post('cartDel','Cart\CartController@cartDel');
    //批量删除
    route::post('delete','Cart\CartController@delete');
    //支付
    route::get('payment/{id}','Cart\CartController@payment');
});
//结算路由
route::prefix('order')->group(function(){
    //点击结算
    route::post('submitOrder','Order\OrderController@submitOrder');
});
//支付宝结算
route::prefix('alipay')->group(function(){
    route::get('mobilepay/{id}',"AlipayController@mobilepay");
    route::any('return',"AlipayController@return");
    route::any('notify',"AlipayController@notify");
});
//登陆注册
route::prefix('user')->group(function(){
    route::get('login','User\UserController@login');
    //手机号注册
    route::get('register','User\UserController@register');
    //唯一性验证
    route::post('checkname','User\UserController@checkname');
    //手机获取获取验证码
    route::post('code','User\UserController@code');
    //邮箱获取验证码
    route::post('edil','User\UserController@edil');
    //注册执行
    route::post('registerAdd','User\UserController@registerAdd');
    //登陆执行
    route::post('loginAdd','User\UserController@loginAdd');
    //我的潮购
    route::get('userpage','User\UserController@userpage');
});
//地址管理
route::prefix('area')->group(function(){
    //展示页面
   route::get('address','Area\AreaController@address');
   //点击默认
    route::post('defalt','Area\AreaController@defalt');
    //点击删除
    route::post('addressDel','Area\AreaController@addressDel');
    //地址添加
    route::get('writeaddr','Area\AreaController@writeaddr');
    //地址添加执行
    route::post('addressAdd','Area\AreaController@addressAdd');
    //地址修改
    route::get('addressEdil/{id}','Area\AreaController@addressEdil');
    //地址修改执行
    route::post('addressEdilAdd','Area\AreaController@addressEdilAdd');
});

route::prefix('users')->group(function(){
   route::get('register','Users\UsersController@register');
    route::post('emil','Users\UsersController@emil');
    route::post('registerAdd','Users\UsersController@registerAdd');
    route::get('login','Users\UsersController@login');
    route::post('loginAdd','Users\UsersController@loginAdd');
    route::get('list','Users\UsersController@list');
});

route::get('memcache','Area\AreaController@memcache');

