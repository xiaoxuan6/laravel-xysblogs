<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
Route::redirect('/admin', '/');

Route::group(['middleware' => 'web'], function () {
    // 后台第三方登录
    Route::get('admins/oauth/github', 'Auth\AdminLoginController@login');
    Route::get('/oauth/github/callback', 'Auth\AdminLoginController@postLogin');
    // 前台
    Route::any('web/oauth/github', 'OauthController@login');
    Route::any('web/oauth/github/callback', 'OauthController@postLogin');
    Route::get('web/oauth/github/logout', 'OauthController@logout');

    Route::get('login', function () {
        \Illuminate\Support\Facades\Session::put('url', \url()->previous());

        return view('home.login');
    });
    // 首页
    Route::get('/', 'IndexController@index');
    Route::get('/author/{author}', 'IndexController@index');
    // 标签
    Route::get('/tag/{tag}', 'IndexController@index');
    // 关于
    Route::get('/about', 'IndexController@about');
    // 学习资料
    Route::get('/book', 'IndexController@book');
    Route::get('/packagist', 'IndexController@packagist');
    // 文章详情
    Route::get('articles/{slug}', 'IndexController@modify');
    Route::post('/point/{id}', 'IndexController@point');
    Route::post('/info/content-{id}', 'IndexController@message')->middleware('auth.oauth');
    // 全局搜索
    Route::get('search', 'IndexController@search');

    // 友链
    Route::get('link', 'IndexController@link');
    Route::post('link/create', 'IndexController@postLink');

    // 文档归案
    Route::get('article/{date}', 'IndexController@getFile');

    // 日志
    Route::get('log', 'LogController@index');
    Route::get('log-end', 'LogController@end');

    // 支付宝
    Route::get('pay', 'PayController@pay');
    Route::get('pay/list', 'PayController@return');

    // 微信支付
    Route::get('wechat', 'WechatPayController@pay');

    // 查看评论
    Route::get('show/discuss', 'IndexController@discuss')->middleware('auth.oauth');

    Route::get('echarts', 'IndexController@echarts');
});

// 支付回调
Route::post('pay/notify', 'PayController@notify');
