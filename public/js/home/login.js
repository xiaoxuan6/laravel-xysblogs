$(function () {
    $('.submit').click(function(){
        // var index=parent.layer.getFrameIndex(window.name);
        window.parent.location.href="/web/oauth/github";
        // window.parent.location.href="/web/oauth/github/callback";
        // $.ajax({
        //     url: '/web/oauth/github',
        //     type: 'get',
        //     success:function(re){
        //         if(re.code == 200){
        //             layer.msg(re.msg);
        //             setTimeout(function(){
        //                 window.parent.location.reload();//刷新父页面
        //                 parent.layer.close(index);//关闭弹出层
        //             }, 1000);
        //         }else{
        //             layer.msg(re.msg, {offset: height, icon: 2});
        //             parent.layer.close(index);//关闭弹出层
        //         }
        //     }
        // });

    });
})