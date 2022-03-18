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

class LinkAactions
{
    protected $id;
    protected $status;

    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.status').on('click', function () {
      var id = $(this).attr('data-id');

      $.ajax({
        method:'post',
        url: '/admin/link/'+id+'/setStatus',
        data:{
            _token:LA.token,
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

        return "<a class='btn btn-xs bg-blue fa grid-check-row status' data-id='{$this->id}' title='{$this->status}'>$this->status</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
