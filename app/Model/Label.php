<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use James\Sortable\SortableTrait;
use James\Sortable\Sortable;

class Label extends Model
{
	use SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'sort_field' => 'order',       // 排序字段
        'sort_when_creating' => true,   // 新增是否自增，默认自增
    ];

    public function article(){
        return $this->belongsToMany(Article::class, 'id',  'label_id');
    }

    public function scopeStatus($query)
    {
        return $query->where('status',1);
    }
}
