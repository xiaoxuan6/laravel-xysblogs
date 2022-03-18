<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\WebService;

class WebComposer
{
    protected $webComposer;

    public function __construct(WebService $commonWebService)
    {
        $this->webComposer = $commonWebService;
    }

    public function compose(View $view)
    {
        $view->with($this->webComposer->index());
    }
}
