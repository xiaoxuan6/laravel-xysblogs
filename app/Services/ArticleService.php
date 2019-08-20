<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/7/2
 * Time: 16:52
 */

namespace App\Services;

use App\Model\Article;
use App\Model\Discuss;
use App\Model\Label;

class ArticleService
{
    /**
     * 文章评论
     * @param Article $article
     * @return Article|bool
     */
    public function edit(Article $article)
    {
        if(!$article->label_id = Label::whereIn('id', $article->label_id)->pluck('title'))
            return false;

        $comment_top = Discuss::status(3)->where(['article_id' => $article->id])->with('oauth')->latest('id')->get();
        $comment_id = $comment_top->pluck('id');
        $childrens = Discuss::status(1)->whereIn('ppid',$comment_id)->with('oauth')->latest('id')->limit(5)->get();

        $comment_top = $this->checkDate($comment_top, $childrens);

        $comment = Discuss::status(1)->where(['ppid' => 0, 'article_id' => $article->id])->with('oauth')->latest('id')->limit(10)->get();
        $comment_id = $comment->pluck('id');
        $comment_childrens = Discuss::status(1)->whereIn('ppid',$comment_id)->with('oauth')->latest('id')->limit(5)->get();

        $arr = $this->checkDate($comment, $comment_childrens);

        $article->comments = collect($comment_top)->merge($arr);

        return $article->load(['user']);
    }

    /**
     * 获取评论子集
     * @param $data
     * @param $childrens
     * @return mixed
     */
    protected function checkDate($data, $childrens)
    {
        return $arr = $data->each(function ($item) use ($childrens){
            return $item->children = $childrens->where('ppid', $item->id)->values();
        });
    }
}