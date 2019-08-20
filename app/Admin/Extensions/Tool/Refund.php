<?php

namespace App\Admin\Extensions\Tool;

use Encore\Admin\Admin;

class Refund
{
    protected $id;
    protected $url;
    protected $prefix;
    protected $status;

    public function __construct($id, $url, $status)
    {
        $this->id = $id;
        $this->url = $url;
        $this->status = $status;
        $this->prefix = config('admin.route.prefix');
    }

    protected function script()
    {
        return <<<SCRIPT
$('.table-responsive').delegate('.status', 'click', function () {
      var id = $(this).attr('data-id');
      var url = $(this).attr('data-url');
      var prefix = $(this).attr('data-prefix');
      $.ajax({
        method:'get',
        url: '/'+prefix+'/'+id+url,
        success:function(re){
          if(re == 1){
            $.pjax.reload('#pjax-container');
            toastr.success('退款成功');
          }else{
            $.pjax.reload('#pjax-container');
            toastr.success('退款失败');
          }
        }
      });
});
SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        if($this->status == 1)
            return "<a class='btn btn-xs bg-blue fa grid-check-row status' data-id='{$this->id}' data-url='{$this->url}' data-prefix='{$this->prefix}' title='退款';>退款</a>";
        else
            return '';
    }

    public function __toString()
    {
        return $this->render();
    }
}