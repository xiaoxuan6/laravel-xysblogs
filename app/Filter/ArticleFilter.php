<?php 
namespace App\Filter;

use James\Eloquent\Filter\Filter;

class ArticleFilter extends Filter
{
    public function keywords($keywords)
    {
        $this->builder->where('name', 'like', "%{$keywords}%");
    }

    public function order($filter)
    {
        switch ((string)$filter){
            case "excellent":
                $this->builder->orderBy('point_num', 'desc');
                break;
            case "popular":
                $this->builder->orderBy('view', 'desc');
                break;
            case "recent":
                $this->builder->orderBy('created_at', 'desc');
                break;
            default:
                $this->builder->orderBy('status', 'desc')->orderBy('id', 'desc');
        }
    }
}