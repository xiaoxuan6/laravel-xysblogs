<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tool\LinkAactions;
use App\Http\Controllers\Controller;
use App\Model\Link;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use James\Admin\Grid;
//use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use James\Admin\Breadcrumb\Layout\Content;
use Lib\Tool;

class LinkController extends Controller
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
            ->header('友情链接')
            ->description('列表')
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
            ->header('友情链接')
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
            ->header('友情链接')
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
            ->header('友情链接')
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
        $grid = new Grid(new Link);

        $grid->id('ID');
        $grid->name('名称');
        $grid->url('链接')->link()->style("width:20px");
        $grid->describe('描述')->limit(20);
        $grid->status('状态')->display(function($val){
            if($val == 1)
                return '<code><span style="color:green">显示</span></code>';
            else
                return "<code>不显示</code>";
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
            if($actions->row->status == 1)
                $name = '不显示';
            else
                $name = '显示';

            $actions->append(new LinkAactions($actions->getKey(), $name));
        });
        $grid->created_at('申请时间');
        $grid->disableRowSelector();
        $grid->disableFilter();
        $grid->disableTools();
        $grid->disableExport();
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
        $show = new Show(Link::findOrFail($id));

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
        $form = new Form(new Link);
        $form->text('name', '名称')->rules('required')->required();
        $form->url('url', '链接')->rules('required|url')->required();
        $form->text('describe', '描述')->rules('required')->required();
        $form->radio('status', '状态')->options(['1' => '显示', 0 => '不显示'])->default(1);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        return $form;
    }

    public function setStatus($id)
    {

        $data = Link::where('id', $id)->first();
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();

        if($data->email)
            Tool::sendEmail('您收到了一封james的邮件', 'James的博客已同意你的友链交换，他的友链地址：'.env('APP_URL'), $data->email);

        return 1;
    }
}
