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

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
//use Encore\Admin\Layout\Content;
use App\Model\{AdminRole, Label};
use App\Http\Controllers\Controller;
use Encore\Admin\{Form, Grid, Show};
use App\Admin\Extensions\Tool\SetStatus;
use James\Admin\Breadcrumb\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;

class LabelController extends Controller
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
            ->header('标签')
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
            ->header('标签 ')
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
            ->header('标签 ')
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
            ->header('标签 ')
            ->description('新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Label());
        $grid->model()->orderBy('order', 'asc');
        if (AdminRole::where('id', Admin::user()->id)->value('name') == '超级管理员') {
            $grid->title('标签名')->editable();
        } else {
            $grid->title('标签名');
        }

        $status = [
            'on' => ['value' => 1, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger'],
        ];
        $grid->status('状态')->switch($status);
        if (AdminRole::where('id', Admin::user()->id)->value('name') == '超级管理员') {
            $grid->order('排序')->sortableColumn(Label::class);
        } else {
            $grid->order('排序');
        }

        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
        $grid->disableactions();
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->add('全部启用', new SetStatus(1, 'label/set-status'));
                $batch->add('全部禁用', new SetStatus(2, 'label/set-status'));
                $batch->disableDelete();
            });
        });
        $grid->disableExport();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->scope('1', '启用')->where('status', '1');
            $filter->scope('2', '禁用')->where('status', '2');
            $filter->like('title', '标签名');
        });

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
        $show = new Show(Label::findOrFail($id));

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
        $form = new Form(new Label());

        $form->text('title', '标签名')->rules(function ($form) {
            return 'required|unique:labels,title,' . $form->model()->id . ',id';
        });
        $status = [
            'on' => ['value' => 1, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => 2, 'text' => '禁用', 'color' => 'danger'],
        ];
        $form->switch('status', '状态')->states($status)->default(1);
        $num = Label::max('order') + 1;
        $form->number('order', '排序')->min($num)->max($num)->default($num);
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

    public function setStatus(Request $request)
    {
        $stauts = $request->input('status');
        $data = Label::whereIn('id', $request->input('ids'))->get();
        foreach ($data as $v) {
            $v->status = $stauts;
            $v->save();
        }
    }
}
