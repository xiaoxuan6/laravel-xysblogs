<?php

namespace App\Admin\Controllers;

use App\Model\Order;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class AdminController extends BaseController
{
    /**
     * this is title
     * @var string
     */
    public $header = '订单';

    /**
     * Notes: model
     * Date: 2019/5/24 17:33
     * @return Order
     */
    public function model()
    {
        return new Order;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function customGrid(Grid $grid)
    {
        $grid->title('标题');
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');
        $grid->actions(function ($actions){
            $actions->disableView();
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function customform(Form $form)
    {
        $form->text('title', '标题');
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
    }
}
