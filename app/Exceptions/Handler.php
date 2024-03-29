<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Exceptions;

use Lib\Tool;
use Exception;
use Illuminate\Http\{JsonResponse, Request, Response};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        /* if (! env('APP_DEBUG') && $exception->getMessage()) {
             // 获取本地日志
             $command = 'cat ' . storage_path('logs/laravel-' . date('Y-m-d') . '.log');
             $command .= ' | grep local.ERROR: | head -10';
             exec($command, $logs);

             $data = end($logs);
             Tool::sendEmail('您收到一封博客报错邮件', $data, env('MAIL_RECEVIE_USER', '1527736751@qq.com'));
         }*/

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response|JsonResponse
     */
    public function render($request, Exception $exception)
    {
        /* 错误页面 */
        if ($this->isHttpException($exception) == 404) {
            /**
             * 执行 php artisan down 项目维护页面
             */
            if ($exception instanceof MaintenanceModeException) {
                return response()->view('error.404');
            }

            return response()->view('error.error');
        } elseif ($this->isHttpException($exception) == 500) {
            return response()->view('error.500');
        }

        /**
         * 定义路由隐式绑定错误码
         */
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['errcode' => __LINE__, 'errmsg' => '暂无数据']);
        }

        return parent::render($request, $exception);
    }
}
