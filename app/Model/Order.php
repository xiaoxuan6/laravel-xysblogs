<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public const TRADE_STATUS = [
        0 => '未支付',
        1 => '支付成功',
        2 => '支付失败',
        3 => '已退款',
        4 => '退款失败',
    ];
}
