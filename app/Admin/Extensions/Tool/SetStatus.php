<?php

namespace App\Admin\Extensions\Tool;
use Encore\Admin\Grid\Tools\BatchAction;

class SetStatus extends BatchAction
{
    protected $action;
    protected $url;

    public function __construct($action = 1, $url = '')
    {
        $this->action = $action;
        $this->url = $url;
    }

    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {
    var ids = selectedRows().join();
    if(!ids){
        swal({
        title: "请选择操作对象!",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确认",
        showLoaderOnConfirm: true,
        cancelButtonText: "取消",
        });
        return false;
    }
        
    $.ajax({
        method: 'post',
        url: '{$this->url}',
        data: {
            _token:LA.token,
            ids: selectedRows(),
            status: {$this->action}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}