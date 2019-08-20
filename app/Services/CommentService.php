<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/7/2
 * Time: 16:58
 */

namespace App\Services;

use App\Model\Article;
use App\Model\Discuss;
use App\Model\Label;
use App\Model\Link;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CommentService
{
    public function index()
    {
        $tags = Cache::remember('web_tags', config('app.limit_ttl'), function(){
            return Label::status()->get(['title','id'])->each(function($item) {
                return $item->num = Article::where('label_id', 'like', '%"'.$item->id.'"%')->status()->count();
            });
        });

        $clickList = Cache::remember('web_click_list', config('app.limit_ttl'), function(){
            $article_id = Redis::connection('article')->zrevrange('article', 0, 2);
            return Article::whereIn('id', $article_id)->get();
        });

        $comment = Cache::remember('web_comment', config('app.limit_ttl'), function(){
            return Discuss::where('status', '<>', Discuss::STATUS_HIDE)->latest('id')->with(['article', 'oauth'])->limit(3)->get();
        });

        $links = Cache::remember('web_links', config('app.limit_ttl'), function(){
            return Link::where('status', 1)->oldest('id')->get();
        });

        $file = Cache::remember('web_file', config('app.limit_ttl'), function(){
           return  DB::table('articles')->select(DB::raw('count(*) as num, substring(created_at, 1, 7) as pub_date'))
            ->where('status', '<>', 2)
            ->groupBy('pub_date')
            ->latest('pub_date')
            ->get();
        });

        return compact('tags', 'clickList', 'comment', 'links', 'file');
    }
}