$(function () {
    $('.login').click(function(){
        //iframe层
        layer.open({
            type: 2,                    // layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）。 若你采用layer.open({type: 1})方式调用，则type为必填项（信息框除外）
            title: '第三方登录',        // 标题
            shadeClose: false,          // 是否点击遮罩关闭
            shade: 0.2,                 // 透明度
            area: ['300px', '160px'],   // 宽高
            offset: '100px',            // 只定义top坐标，水平保持居中
            move: false,                // 禁止拖拽
            resize:false,               // 是否允许拉伸
            content: '/login'           //iframe的url
        });
    });
    $('.logout').click(function(){
        $.ajax({
            url: '/web/oauth/github/logout',
            type: 'get',
            success:function (re) {
                layer.msg(re.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 100);
            }
        })
    })
})