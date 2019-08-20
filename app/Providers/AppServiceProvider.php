<?php

namespace App\Providers;

use App\Validators\PhoneValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

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
        ini_set('memory_limit', "256M");

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
        foreach ($this->validators as $key => $value)
        {
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
