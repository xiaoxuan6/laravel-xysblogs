<?php

namespace App\Admin\Extensions\Tool;

use Encore\Admin\Admin;

class GoBack
{
	protected $url;

	public function __construct($url = '')
	{
	    $this->url = $url;
	}

    protected function render()
    {
    	if($this->url)
        	return "<a href='".$this->url."' class='fa fa-arrow-left btn btn-sm btn-default form-history-back' >返回</a>";
        else
        	return "<a href='javascript:history.go(-1)' class='fa fa-arrow-left btn btn-sm btn-default form-history-back' >返回</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}