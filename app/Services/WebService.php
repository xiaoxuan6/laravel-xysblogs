<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/7/2
 * Time: 16:52
 */

namespace App\Services;

use App\Model\ArticleRecord;
use App\Model\Banner;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class WebService
{
    public function index()
    {
        $count = Cache::remember('web_count', config('app.limit_ttl'), function(){
            return array_sum(Redis::connection('article')->ZRANGEBYSCORE('article', 0, 10000, "withscores"));
        });

        $number = Cache::remember('web_number', config('app.limit_ttl'), function(){
            return ArticleRecord::get()->unique('ip')->count();
        });

        $banner = Cache::remember('web_banner', config('app.limit_ttl'), function(){
            return Banner::where('status', 1)->oldest('sort')->get();
        });

        return compact('count', 'number', 'banner');
    }
}