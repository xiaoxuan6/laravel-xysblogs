<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Http\Controllers;

use Carbon\Carbon;
use Packagist\Api\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Redis};
use App\Filter\{ArticleFilter, DiscussFilter};
use App\Http\Requests\{LinkRequest, MessageRequest};
use App\Model\{Article, Book, Discuss, Label, Link, Project};
use App\Services\{ArticleRecordService, ArticleService, EchartsService};

class IndexController extends Controller
{
    protected $redis;

    public function __construct()
    {
        $this->redis = Redis::connection('article');
    }

    /**
     * 首页
     * @param Request $request
     * @param string $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $tag = '', ArticleFilter $articleFilter)
    {
        $ip = $request->getClientIp();

        $filter = $request->input('filter', '');

        $data = Article::status()
            ->filter($articleFilter, 'order')
            ->ofTag($tag)
            ->ofAuthor($tag)
            ->with(['user']);

        $data = $data->paginate(10)->appends($request->all());

        /**
         * 模糊查询如果没有数据使用TNTSearch 全文搜索
         */
        if (! $data) {
            $data = Article::search($request->input('keywords', ''))->get();
        }

        $label = Label::status()->get(['title', 'id']);

        foreach ($data as $v) {
            $v->label_id = $label->whereIn('id', $v->label_id)->values()->pluck('title');
            $v->point_num = $this->redis->get('likes_count' . $v->id) ?? 0;
            $v->status_like = $this->redis->sismember($v->id, $ip);
        }

        return view('home.index', compact('tag', 'data', 'filter'));
    }

    /**
     * 文章详情
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modify(Request $request, $slug, ArticleService $articleService, ArticleRecordService $articleRecordService)
    {
        $ip = $request->getClientIp();

        if (! $article = Article::where('slug', $slug)->first()) {
            return view('error.error');
        }

        $id = $article->id;
        $this->redis->zscore('article', $id) ? $this->redis->zincrby('article', 1, $id) : $this->redis->zadd('article', 1, $id);

        $articleRecordService->insert($id, $ip);

        if (! $data = $articleService->edit($article)) {
            return view('error.error');
        }

        $data['prev_data'] = Article::where('id', '<', $id)->latest('id')->first();
        $data['next_data'] = Article::where('id', '>', $id)->oldest('id')->first();

        $point = $this->redis->get('likes_count' . $data->id);
        $status = $this->redis->sismember($data->id, $ip);

        return view('home.info', compact('data', 'point', 'status'));
    }

    /**
     * 点赞
     * @param Request $request
     * @param $id
     * @return array
     */
    public function point(Request $request, $id)
    {
        $ip = $request->getClientIp();
        if (! $article_id = Article::where('id', $id)->value('id')) {
            return ['code' => __LINE__, 'msg' => '点赞失败，请重试！'];
        }

        $this->redis->sadd('article_like', $article_id);

        if ($this->redis->sadd($article_id, $ip)) {
            $this->redis->incr('likes_count' . $article_id);
            $this->redis->zadd('user:' . $ip, strtotime(now()), $article_id);

            return ['code' => 200, 'msg' => '点赞成功！'];
        }
        $this->redis->srem($article_id, $ip);
        $this->redis->decr('likes_count' . $article_id);
        $this->redis->zrem('user:' . $ip, $article_id);

        return ['code' => 200, 'msg' => '取消点赞！'];
    }

    /**
     * 评论
     * @param Request $request
     * @param $id
     * @return array
     */
    public function message(MessageRequest $request, $id)
    {
        $data = $request->only(['comment', 'pid']) + ['status' => Discuss::STATUS_SHOW , 'article_id' => $id, 'oauth_id' => Auth::guard('oauth')->user()->id];
        if (Discuss::store($data)) {
            return ['code' => 200];
        }

        return ['code' => __LINE__, 'msg' => '评论失败'];
    }

    /**
     * 关于
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $list = Project::where('status', 1)->latest('id')->get();

        return view('home.about', compact('list'));
    }

    /**
     * 学习资源
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function book()
    {
        $list = Book::latest('id')->paginate(20);

        return view('home.book', compact('list'));
    }

    /**
     * Packagist 包
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Packagist()
    {
        $client = new Client();

        $list = [];
        foreach ($client->search('james.xue') as $v) {
            Str::startsWith($v->getName(), 'james.xue') ? $list[] = $this->checkString($v->getName()) : '';
        }

        return view('home.packagist', compact('list'));
    }

    /**
     * Notes: 处理字符串
     * Date: 2019/8/14 16:50
     * @param $name
     * @return mixed
     */
    private function checkString($name)
    {
        return str_replace(['james.xue', 'login-captcha-username', 'ali-safe-api'], ['xiaoxuan6', 'login-catpcha-username', 'aliyun-safe'], $name);
    }

    /**
     * 友链
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link()
    {
        $links = Link::where('status', 1)->get();

        return view('home.link', compact('links'));
    }

    /**
     * 添加友链
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLink(LinkRequest $request)
    {
        $data = $request->only(['name', 'url', 'describe', 'email']) + ['status' => 0, 'created_at' => Carbon::now('Asia/Shanghai'), 'updated_at' => Carbon::now('Asia/Shanghai')];
        if (Link::create($data)) {
            return ['code' => 200, 'msg' => '申请成功！'];
        }

        return ['code' => 201, 'msg' => '申请失败，请重试！'];
    }

    /**
     * Notes: 文档归案
     * Date: 2019/5/5 18:08
     * @param Request $request
     * @param $date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFile($date)
    {
        $data = Article::where('created_at', 'like', '%' . $date . '%')->status()->get()->each(function ($item) {
            return $item->times = date('d日 h:i', strtotime($item['created_at']));
        });

        return view('home.time', compact('data', 'date'));
    }

    /**
     * Notes: 评论
     * Date: 2019/8/2 15:23
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function discuss(DiscussFilter $discussFilter)
    {
        $data = Discuss::filter($discussFilter, ['oauthId', 'status'])->with(['article', 'oauth'])->latest('id')->get();

        return view('home.discuss', compact('data'));
    }

    /**
     * 访问量
     * @param EchartsService $echartsService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function echarts(EchartsService $echartsService)
    {
        $visits_count = $echartsService->getVisit();

        $data = $echartsService->getEchart();
        $num = $data->pluck('num')->implode(',');
        $pub_date = $data->pluck('pub_date')->implode(',');

        $china_data = $visits_count['china_count']->map(function ($item) {
            $item->name = str_replace(['省', '市'], ['',''], $item->name);

            return $item;
        })->toArray();

        $china_count = count($visits_count['china_count']);

        return view('home.echarts', compact('visits_count', 'num', 'pub_date', 'china_data', 'china_count'));
    }
}
