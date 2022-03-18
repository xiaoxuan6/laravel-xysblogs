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

class Label extends Model
{
    use SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'sort_field' => 'order',       // 排序字段
        'sort_when_creating' => true,   // 新增是否自增，默认自增
    ];

    public function article()
    {
        return $this->belongsToMany(Article::class, 'id',  'label_id');
    }

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }
}
