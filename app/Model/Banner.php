<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use James\Sortable\SortableTrait;
use James\Sortable\Sortable;

class Banner extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'sort_field' => 'sort',       // 排序字段
        'sort_when_creating' => true,   // 新增是否自增，默认自增
    ];
}
