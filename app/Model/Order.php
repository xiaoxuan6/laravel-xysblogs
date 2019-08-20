<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    const TRADE_STATUS = [
        0 => '未支付',
        1 => '支付成功',
        2 => '支付失败',
        3 => '已退款',
        4 => '退款失败',
    ];
}
