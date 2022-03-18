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
use James\Sortable\{Sortable, SortableTrait};

class Banner extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'sort_field' => 'sort',       // 排序字段
        'sort_when_creating' => true,   // 新增是否自增，默认自增
    ];
}
