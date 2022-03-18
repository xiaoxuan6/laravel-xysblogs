<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Providers;

use Carbon\Carbon;
use Laravel\Horizon\Horizon;
use App\Validators\PhoneValidator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Schema, Validator};

class AppServiceProvider extends ServiceProvider
{
    protected $validators = [
        'phone' => PhoneValidator::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');
        Schema::defaultStringLength(191);
        /**
         * 增加内存防止中文分词报错
         */
        ini_set('memory_limit', '256M');

        $this->registerValidator();

        // 开启队列
//        Horizon::auth(function ($request) {
//                return true;
//        });
    }

    /**
     * Notes: 注册自定义规则
     * Date: 2019/5/27 16:28
     */
    protected function registerValidator()
    {
        foreach ($this->validators as $key => $value) {
            Validator::extend($key, $value);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
