<?php

namespace App\Http\ViewComposers;

use App\Services\CommentService;
use Illuminate\View\View;

class CommonComposer
{
    /**
     * @var CommentService
     */
    protected $commonCommentService;

    /**
     * CommonController constructor.
     * @param CommentService $commonCommentService
     */
    public function __construct(CommentService $commonCommentService)
    {
        $this->commonCommentService = $commonCommentService;
    }

    /**
     * Notes: 当渲染指定的模板时，Laravel 会调用 compose 方法
     * Date: 2019/7/2 17:04
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with($this->commonCommentService->index());
    }
}
