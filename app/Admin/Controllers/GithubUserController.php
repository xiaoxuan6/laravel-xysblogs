<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Model\GithubUser;
use App\Model\Oauth;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
//use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use James\Admin\Breadcrumb\Layout\Content;

class GithubUserController extends Controller
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
            ->header('github')
            ->description('用户')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Oauth());

        $grid->id('ID')->sortable();
        $grid->avatar('头像')->image('',30,30);
        $grid->username('昵称');
        $grid->name('姓名');
        $grid->email('邮箱')->prependIcon('envelope');
        $grid->github_url('github 地址')->link();
        $grid->company('公司');
        $grid->created_at('创建时间');
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableActions();
        $grid->disableCreateButton();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Oauth::findOrFail($id));

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
    protected function form()
    {
        $form = new Form(new Oauth());

        return $form;
    }
}
