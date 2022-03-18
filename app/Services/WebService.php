<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Services;

use App\Model\{ArticleRecord, Banner};
use Illuminate\Support\Facades\{Cache, Redis};

class WebService
{
    public function index()
    {
        $count = Cache::remember('web_count', config('app.limit_ttl'), function () {
            return array_sum(Redis::connection('article')->ZRANGEBYSCORE('article', 0, 10000, 'withscores'));
        });

        $number = Cache::remember('web_number', config('app.limit_ttl'), function () {
            return ArticleRecord::get()->unique('ip')->count();
        });

        $banner = Cache::remember('web_banner', config('app.limit_ttl'), function () {
            return Banner::where('status', 1)->oldest('sort')->get();
        });

        return compact('count', 'number', 'banner');
    }
}
