<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Http\Controllers;

use Pay;
use Carbon\Carbon;
use App\Model\Order;
use App\Jobs\CloseOrder;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function pay()
    {
        $total = '0.01';
        $out_trade_no = time();
        $subject = 'test subject - 测试';

        $order = [
            'out_trade_no' => $out_trade_no,
            'total_amount' => $total,
            'subject' => $subject,
        ];

        $create_order = Order::create([
            'out_trade_no' => $out_trade_no,
            'title' => $subject,
            'total_amount' => $total,
        ]);

        $this->dispatch(new CloseOrder($create_order, env('ORDER_TTL', 120)));

        return Pay::alipay()->web($order);
    }

    // 同步通知地址
    public function return()
    {
        // 验证是否支付成功，这里没有用到
        Pay::alipay()->verify();

        $data = Order::latest()->limit(5)->get()->toArray();
        array_walk($data, function (&$item) {
            $item['pay_time'] = date('Y-m-d', strtotime($item['pay_time']));
            $item['trade_status'] = Order::TRADE_STATUS[$item['trade_status']];
        });

        return view('home.pay', compact('data'));
    }

    // 异步通知地址
    public function notify(Request $request)
    {
        $data = Pay::alipay()->verify();

        // 如果订单状态不是成功或者结束，则不走后续的逻辑
        if (! in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            return Pay::alipay()->success();
        }

        // 查询订单
        if (! $order = Order::where('out_trade_no', $data->out_trade_no)->first()) {
            return 'fail';
        }

        // 已支付
        if ($order->trade_status == 1) {
            return Pay::alipay()->success();
        } // // 返回数据给支付宝

        $order->update([
            'pay_time' => Carbon::now(),
            'buyer_id' => $data->buyer_id,
            'trade_status' => $data->trade_status == 'TRADE_SUCCESS' ? 1 : 2,
            'trade_no' => $data->trade_no,
            'extra' => $data,
        ]);

        return Pay::alipay()->success();
    }
}
