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

use Pay;
use App\Model\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\{Form, Grid, Show};
//use Encore\Admin\Layout\Content;
use App\Admin\Extensions\Tool\Refund;
use James\Admin\Breadcrumb\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;

class OrderController extends Controller
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
            ->header('订单')
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
            ->header('Detail')
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
        $grid = new Grid(new Order());

        $grid->id('ID');
        $grid->out_trade_no('订单号');
        $grid->title('标题');
        $grid->buyer_id('购买人的id');
        $grid->total_amount('金额');
        $grid->trade_status('状态')->display(function ($value) {
            return Order::TRADE_STATUS[$value];
        });
        $grid->pay_time('支付时间');
        $grid->created_at('创建时间');
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            $status = $actions->row->trade_status;
            $actions->append(new Refund($actions->getKey(), '/order/refund', $status));
        });
        $grid->disableExport();
        $grid->disableFilter();
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
        $show = new Show(Order::findOrFail($id));

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
        return new Form(new Order());
    }

    /**
     * Notes: 退款
     * Date: 2019/5/23 16:11
     * @param $id
     * @return int
     */
    public function refund($id)
    {
        if (! $order = Order::where('id', $id)->first()) {
            return 0;
        }

        if ($order->trade_status != 1) {
            return 0;
        }

        $out_no = time();

        $result = Pay::alipay()->refund([
            'out_trade_no' => $order->out_trade_no,
            'refund_amount' => $order->total_amount,
            'out_request_no' => $out_no,
        ]);

        if ($result->sub_code) {
            $order->update(['trade_status' => 3, 'out_request_no' => $out_no, 'extra' => $order->extra]);

            return 0;
        }
        $order->update(['trade_status' => 2, 'out_request_no' => $out_no, 'extra' => $order->extra]);


        return 1;
    }
}
