<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/7/2
 * Time: 17:39
 */

namespace App\Http\ViewComposers;

use App\Services\WebService;
use Illuminate\View\View;

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