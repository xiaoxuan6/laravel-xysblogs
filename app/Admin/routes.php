<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();
// 测试发送邮件
//Route::get('admin/send-mail/{username}/{password}', 'App\Admin\Controllers\RegisterController@sendEmail');
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
], function (Router $router) {
    // 注册
    $router->get('auth/register', 'RegisterController@index');
    $router->post('auth/register', 'RegisterController@postRegister');
    // 发送短信
    $router->post('auth/sms', 'RegisterController@sendSms');
});

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    // 登录
    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');
    $router->get('auth/logout', 'AuthController@getLogout');

    $router->post('label/set-status', 'LabelController@setStatus');     // 标签状态
    $router->post('article/add-black', 'ArticleController@addBlack');   // 文章加入黑名单
    $router->post('comment/set-status', 'CommentController@status');    // 单条状态
    $router->post('comment/post', 'CommentController@commentReply');    // 回复评论
    $router->post('comment/{id}', 'CommentController@setStatus');       // 批量操作
    $router->get('comment/detail-{id}', 'CommentController@reply');     // 评论详情
    $router->get('article/comment/delete/{id}', 'CommentController@delete');     // 删除评论
    $router->get('black/{id}/show', 'BlacklistController@view');        // 查看黑名单
    $router->post('link/{id}/setStatus', 'LinkController@setStatus');   // 友情链接
    $router->get('{id}/order/refund', 'OrderController@refund');        // 退款
    $router->post('article/{id}/top', 'ArticleController@sticky');      // 文章置顶
    $router->post('notice/create', 'HomeController@notice');            // 设置公告

    $router->get('/', 'HomeController@index');
    $router->resource('auth/users', UserController::class);
    $router->resource('label', LabelController::class);
    $router->resource('article', ArticleController::class);
    $router->resource('black-list', BlacklistController::class);
    $router->resource('github-user', GithubUserController::class);
    $router->resource('book', BookController::class);
    $router->resource('project', ProjectController::class);
    $router->resource('banner', BannerController::class);
    $router->resource('article/{id}/comment', CommentController::class);
    $router->resource('link', LinkController::class);
    $router->resource('order', OrderController::class);
    $router->resource('base', AdminController::class);


});
