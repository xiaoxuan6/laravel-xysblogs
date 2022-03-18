<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Filter;

use App\Model\Discuss;
use James\Eloquent\Filter\Filter;
use Illuminate\Support\Facades\Auth;

class DiscussFilter extends Filter
{
    public function oauthId()
    {
        $this->builder->where('oauth_id', Auth::guard('oauth')->user()->id);
    }

    public function status()
    {
        $this->builder->where('status', '<>', Discuss::STATUS_HIDE);
    }
}
