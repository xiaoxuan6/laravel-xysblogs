<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Admin\Extensions\Tool;

class GoBack
{
    protected $url;

    public function __construct($url = '')
    {
        $this->url = $url;
    }

    protected function render()
    {
        if ($this->url) {
            return "<a href='" . $this->url . "' class='fa fa-arrow-left btn btn-sm btn-default form-history-back' >返回</a>";
        }

        return "<a href='javascript:history.go(-1)' class='fa fa-arrow-left btn btn-sm btn-default form-history-back' >返回</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
