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

use Encore\Admin\Admin;

class AactionsTop
{
    protected $id;
    protected $status;
    protected $prefix;

    public function __construct($id, $status)
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
        url: '/'+prefix+'/article/' + id + '/top',
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
            return "&nbsp;<a class='btn btn-xs bg-green fa grid-check-row status' data-id='{$this->id}' data-status='3' data-prefix='{$this->prefix}' title='置顶';>置顶</a>&nbsp;&nbsp;";
        }

        return "&nbsp;<a class='btn btn-xs bg-red fa grid-check-row status' data-id='{$this->id}' data-status='3' data-prefix='{$this->prefix}' title='取消置顶';>取消置顶</a>&nbsp;&nbsp;";
    }

    public function __toString()
    {
        return $this->render();
    }
}
