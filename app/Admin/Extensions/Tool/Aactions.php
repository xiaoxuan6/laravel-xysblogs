<?php

namespace App\Admin\Extensions\Tool;

use Encore\Admin\Admin;

class Aactions
{
    protected $id;
    protected $status;
    protected $prefix;

    public function __construct($id,$status)
    {
        $this->id = $id;
        $this->status = $status;
        $this->prefix = config('admin.route.prefix');
    }

    protected function script()
    {
        return <<<SCRIPT

$('.status').on('click', function () {
      var id = $(this).attr('data-id');
      var status = $(this).attr('data-status');
      var prefix = $(this).attr('data-prefix');

      $.ajax({
        method:'post',
        url: '/'+prefix+'/comment/'+id,
        data:{
            _token:LA.token,
            status:status
        },
        success:function(re){
          if(re == 1){
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功！');
          }else{
            $.pjax.reload('#pjax-container');
            toastr.success('操作失败！');
          }
        }
      });
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        if ($this->status == 1) {
            return "<a class='btn btn-xs bg-blue fa grid-check-row status' data-id='{$this->id}' data-status='2' data-prefix='{$this->prefix}' title='隐藏';>隐藏</a>&nbsp;<a class='btn btn-xs bg-red fa grid-check-row status' data-id='{$this->id}' data-status='3' data-prefix='{$this->prefix}' title='置顶';>置顶</a>";
        } elseif ($this->status == 2){
            return "<a class='btn btn-xs bg-green fa grid-check-row status' data-id='{$this->id}' data-status='1' data-prefix='{$this->prefix}' title='显示';>显示</a>&nbsp;<a class='btn btn-xs bg-red fa grid-check-row status' data-id='{$this->id}' data-status='3' data-prefix='{$this->prefix}' title='置顶';>置顶</a>";
        }else {
            return "<a class='btn btn-xs bg-green fa grid-check-row status' data-id='{$this->id}' data-status='1' data-prefix='{$this->prefix}' title='显示';>显示</a>&nbsp;<a class='btn btn-xs bg-blue fa grid-check-row status' data-id='{$this->id}' data-status='2' data-prefix='{$this->prefix}' title='隐藏';>隐藏</a>";
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}