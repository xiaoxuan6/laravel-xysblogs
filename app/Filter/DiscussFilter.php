<?php 
namespace App\Filter;

use App\Model\Discuss;
use Illuminate\Support\Facades\Auth;
use James\Eloquent\Filter\Filter;

class DiscussFilter extends Filter
{
    public function oauthId()
    {
        $this->builder->where('oauth_id', Auth::guard('oauth')->user()->id);
    }

    public function status()
    {
        $this->builder->where('status', '<>',Discuss::STATUS_HIDE);
    }
}