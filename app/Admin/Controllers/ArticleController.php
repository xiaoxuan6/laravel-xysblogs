<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Admin\Controllers;

use James\Admin\Grid;
use App\Lib\SlugTranslate;
use Illuminate\Http\Request;
use Encore\Admin\{Form, Show};
//use Encore\Admin\Layout\Content;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use App\Admin\Extensions\ExcelExpoter;
use James\Admin\Breadcrumb\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
use App\Admin\Extensions\Tool\{AactionsTop, AddBlack};
use App\Model\{AdminRole, AdminUser, Article, Comment, Discuss, Label};

class ArticleController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('预览')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('修改')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('文章管理')
            ->description('添加')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());
        if (AdminRole::where('id', Admin::user()->id)->value('name') == '超级管理员') {
            $grid->model()->status()->orderBy('id', 'desc');
        } else {
            $grid->model()->status()->where('user_id', Admin::user()->id)->orderBy('id', 'desc');
        }

        $grid->id('ID');
        $grid->name('标题')->limit(30);
        $grid->user()->name('作者');
        $grid->label_id('标签')->display(function ($label_id) {
            return Label::whereIn('id', $label_id)->pluck('title');
        })->label();
        $grid->content('内容')->limit(30)->display(function ($val) {
            return strip_tags($val);
        });
        $grid->view('浏览量')->style('width:60px;');
        $grid->column('评论数')->display(function () {
            return Discuss::where('article_id', $this->id)->where('status', '<>', Discuss::STATUS_HIDE)->count();
        });
        $grid->point_num('点赞数');
        $grid->created_at('创建时间');
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->append(new AactionsTop($actions->getKey(), $actions->row->status));
            $actions->append('<a title="查看评论" href="article/' . $actions->getKey() . '/comment" class="btn btn-xs bg-blue fa grid-check-row">  查看评论 </a>');
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->add('加入黑名单', new AddBlack(2));
            });
        });
        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->disableIdFilter();
                $filter->like('name', '标题');
                if (AdminRole::where('id', Admin::user()->id)->value('name') == '超级管理员') {
                    $filter->where(function ($query) {
                        $id = AdminUser::where('name', 'like', "%{$this->input}%")->pluck('id');
                        $query->whereIn('user_id', $id);
                    }, '作者');
                }
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->where(function ($query) {
                    $query->where('label_id', 'like', "%{$this->input}%");
                }, '标签', '标签')->select(Label::where('status', 1)->pluck('title', 'id'));
            });
        });

        $filename = '文章管理 ';
        $head = ['ID','标题','作者','标签','内容','创建时间'];
        $body = ['id','name','author','label_id','content','created_at'];
        $grid->exporter(new ExcelExpoter($filename, $head, $body, 'csv'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->name('标题');
        $show->user()->name('作者');
        $show->label_id('标签')->as(function ($label_id) {
            return Label::whereIn('id', $label_id)->pluck('title');
        })->label();
        $show->content('内容')->as(function ($content) {
            return strip_tags($content);
        });

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });;

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());
        $form->text('name', '标题')->rules('required|min:6')->required();
        $form->text('author', '作者')->value(Admin::user()->name)->ReadOnly();
        $form->multipleSelect('label_id', '标签')->options(Label::where('status', 1)->pluck('title', 'id'))->rules('required')->required();
        $form->editor('content', '内容')->rules('required')->required();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        $form->hidden('user_id')->value(Admin::user()->id);
        $form->hidden('uuid')->value(time());
        $form->ignore(['author']);
        $form->saving(function ($form) {
            $form->model()->slug = app(SlugTranslate::class)->translate($form->name);
        });

        return $form;
    }

    public function addBlack(Request $request)
    {
        foreach (Article::whereIn('id', $request->input('ids'))->get() as $v) {
            $v->status = $request->input('status');
            $v->save();
        }
    }

    /**
     * Notes: 置顶操作
     * Date: 2019/6/12 18:30
     * @param $id
     * @return int
     */
    public function sticky($id)
    {
        $article = Article::where('id', $id)->first();
        $article->status = $article->status == 1 ? 3 : 1;
        $article->save();

        return 1;
    }
}
