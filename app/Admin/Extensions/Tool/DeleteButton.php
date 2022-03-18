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

class DeleteButton
{
    protected $id;
    protected $url;

    public function __construct($id, $url)
    {
        $this->id = $id;
        $this->url = $url;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.table-responsive').delegate('.del', 'click', function () {
      var id = $(this).attr('data-id');
      var url = $(this).attr('data-url');
      $.ajax({
        method:'get',
        url:url+id,
        success:function(re){
          if(re == 1){
            $.pjax.reload('#pjax-container');
            toastr.success('删除成功');
          }else{
            $.pjax.reload('#pjax-container');
            toastr.success('删除失败');
          }
        }
      });
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<span class='del' data-id='{$this->id}' data-url='{$this->url}'><i class='fa fa-trash' style='color: #d73925;'></i> <span style='color: #1e282c'>删除</span></span>&nbsp;";
    }

    public function __toString()
    {
        return $this->render();
    }
}
