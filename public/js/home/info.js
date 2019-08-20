$(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    // 点赞
    $('.point').click(function () {
        var _this = $(this);
        var id = _this.attr('data-id');
        var height = parseInt($(window).width() / 4);
        $.ajax({
            url: '/point/' + id,
            type: 'post',
            data: {id: id},
            success: function (re) {
                layer.msg(re.msg, {offset: height, icon: 1});
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        });
    });

    // 发表评论
    $('.comments').click(function () {
        var comment_show = $('.comment_show').css('display');
        if(comment_show == 'block'){
            $('.comment_show').css('display', 'none');
            $('.replay-nickname').css('display', 'none');
            $('.comment').val('');
        }else{
            $('.comment_show').css('display', 'block');
            $('.pid').val(0);
            $('.title').html('评论内容：');
        }
    });

    // 回复
    $('.replay').click(function () {
        $('.comment_show').css('display', 'block');
        $('.replay-nickname').css('display', 'block');
        $('.pid').val($(this).attr('data-id'));
        $('.title').html('回复内容：');
        var nickname = $(this).closest('.parent').find('.nickname').html();
        var string = nickname.replace('昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：', '');
        var replay = '回&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;复：' + string;
        $('.replays').html(replay);
    });

    // 评论
    $('.tijioa').click(function () {
        var id = $('.id').val();
        var pid = $('.pid').val();
        // var name = $('.name').val();
        var height = parseInt($(window).width() / 4);
        // if(!name){
        //     layer.msg('请输入昵称！', {offset: height, icon: 2});
        //     $('.name').focus();
        //     return;
        // }
        // var contact = $('.contact').val();
        // var re = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
        // if(!contact || !re.test(contact)){
        //     layer.msg('请输入正确联系方式！', {offset: height, icon: 2});
        //     $('.contact').focus();
        //     return;
        // }
        var oauth= $('.oauth').val();
        if(!oauth){
            layer.msg('请登录！', {offset: height, icon: 2});
            return false;
        }

        var comment = $('.comment').val();
        if(!comment){
            layer.msg('请输入评论内容！', {offset: height, icon: 2});
            $('.comment').focus();
            return;
        }
        $.ajax({
            url: '/info/content-'+id,
            type: 'post',
            data: {'comment':comment,'pid':pid },
            // data: {'contact':contact,'comment':comment,'name':name,'pid':pid },
            success:function (re) {
                if(re.code == 200){
                    if(pid == 0){
                        layer.msg('评论成功！', {offset: height, icon: 1});
                    }else{
                        layer.msg('回复成功！', {offset: height, icon: 1});
                    }
                    setTimeout(function(){
                        window.location.reload();
                    },1000);
                }else{
                    if(pid == 0){
                        layer.msg(re.msg, {offset: height, icon: 2});
                    }else{
                        layer.msg(re.msg, {offset: height, icon: 2});
                    }
                    if(re.code != 401){
                        setTimeout(function(){
                            window.location.reload();
                        },1000);
                    }else{
                        setTimeout(function(){
                            $('.login').click();
                        }, 1000);
                    }
                }
            }
        });
    });
})