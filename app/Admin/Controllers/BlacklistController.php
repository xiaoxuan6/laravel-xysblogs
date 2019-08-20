<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Label;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
//use Encore\Admin\Layout\Content;
use James\Admin\Breadcrumb\Layout\Content;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Show;
use App\Model\Article;
use App\Admin\Extensions\Tool\AddBlack;

class BlacklistController extends Controller
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
            ->header('黑名单')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->model()->where('status',2)->where('user_id', Admin::user()->id);
        $grid->name('标题');
        $grid->author('作者');
        $grid->label_id('标签')->display(function($label_id){
            return Label::whereIn('id', $label_id)->pluck('title');
        })->label();
        $grid->content('内容')->limit(30);
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->tools(function ($tools) {
            $tools->disableRefreshButton();
            $tools->batch(function ($batch) {
                $batch->add('移除黑名单',new AddBlack(1));
                $batch->disableDelete();
            });
        });
        $grid->filter(function ($filter){
            $filter->column(1/2, function ($filter) {
                $filter->disableIdFilter();
                $filter->like('name','标题');
            });
            $filter->column(1/2, function ($filter) {
                $filter->where(function ($query) {
                    $query->where('label_id', 'like', "%{$this->input}%");
                }, '标签', '标签')->select(Label::where('status',1)->pluck('title','id'));
            });
        });
        $grid->actions(function($actions){
            $actions->disableView();
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->append('<a href="black/'.$actions->getKey().'/show" class="fa btn btn-sm btn-default">查看</a>');
        });
        return $grid;
    }

    /**
     * 查看
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Content $content, $id)
    {
        $data = Article::find($id);
        $data->label_name = Label::where('id', $data->label_id)->pluck('title')->implode(',');

        return $content
            ->header('黑名单')
            ->description('查看')
            ->body(view('admin.show', compact('data')));
    }

}
