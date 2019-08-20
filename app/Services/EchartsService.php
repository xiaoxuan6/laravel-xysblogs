<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/7/2
 * Time: 16:52
 */

namespace App\Services;

use App\Model\ArticleRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EchartsService
{
    /**
     * 昨日、上周、上月
     * @return mixed
     */
    public function getVisit()
    {
        $visits_count['yesterday'] = Cache::remember('echarts_yesterday', config('app.echarts_yesterday_limit_ttl'), function(){
           return ArticleRecord::whereDate('created_at', Carbon::yesterday()
               ->format('Y-m-d'))
               ->count();
        });

        $visits_count['last_week'] = Cache::remember('echarts_last_week', config('app.echarts_week_limit_ttl'), function(){
            return ArticleRecord::whereDate('created_at', '>=', Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'))
                ->whereDate('created_at', '<=', Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'))
                ->count();
        });

        $visits_count['last_month'] = Cache::remember('echarts_last_month', config('app.echarts_month_limit_ttl'), function(){
            return ArticleRecord::whereDate('created_at', '>=', Carbon::now()->subMonth()->firstOfMonth()->format('Y-m-d'))
                ->whereDate('created_at', '<=', Carbon::now()->subMonth()->lastOfMonth()->format('Y-m-d'))
                ->count();
        });

        $visits_count['china_count'] = ArticleRecord::select(DB::raw("count(province) as value, province as name"))
            ->whereNotNull('province')
            ->groupBy('province')
            ->orderBy('value', 'desc')
            ->get();

        return $visits_count;
    }

    /**
     * 获取近七日访问量
     * @return mixed
     */
    public function getEchart()
    {
        return ArticleRecord::select(\DB::raw('count(*) as num, substring(created_at, 1, 10) as pub_date'))
            ->whereDate('created_at', '>=', Carbon::now()->subDay(6)->format('Y-m-d'))
            ->groupBy('pub_date')
            ->get();
    }
}