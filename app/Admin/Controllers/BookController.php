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
use Encore\Admin\{Form, Show};
use Encore\Admin\Facades\Admin;
use App\Model\{AdminRole, Book};
//use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use James\Admin\Breadcrumb\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;

class BookController extends Controller
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
            ->header('资源')
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
            ->header('资源')
            ->description('description')
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
            ->header('资源')
            ->description('修改')
            ->body($this->form($id)->edit($id));
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
            ->header('资源')
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
        $grid = new Grid(new Book());
        $grid->model()->orderBy('id', 'desc');
        $grid->id('ID')->sortable();
        $grid->title('标题')->limit(50);
        $grid->image('图片')->image('', 100, 100);
        $grid->url('链接')->link();;
        $grid->created_at('创建时间');
        if (AdminRole::where('id', Admin::user()->id)->value('name') == '超级管理员') {
            $grid->actions(function ($actions) {
                $actions->disableView();
            });
        } else {
            $grid->disableActions();
        }

        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();

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
        $show = new Show(Book()::findOrFail($id));

        $show->id('ID');
        $show->created_at('创建时间');
        $show->updated_at('修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = '')
    {
        $form = new Form(new Book());
        $form->text('title', '标题')->rules('required')->required();
        $form->url('url', '链接')->rules('required')->required();
        if ($id) {
            $form->image('image', '图片')->uniqueName()->rules('required');
        } else {
            $form->image('image', '图片')->uniqueName()->rules('required')->required();
        }

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
