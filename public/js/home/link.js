$(function(){
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('.save').click(function(){
        var name = $('#name').val();
        var url = $('#url').val();
        var describe = $('#describe').val();
        var email = $('#email').val();
        var height = parseInt($(window).width() / 4);
        if(!name){
            layer.msg('请输入标题！', {offset: height, icon: 2});
            $('#name').focus();
            return;
        }

        var match = /^((ht|f)tps?):\/\/([\w\-]+(\.[\w\-]+)*\/)*[\w\-]+(\.[\w\-]+)*\/?(\?([\w\-\.,@?^=%&:\/~\+#]*)+)?/;
        if(!url || !match.test(url)){
            layer.msg('请输入正确格式的链接！', {offset: height, icon: 2});
            $('#url').focus();
            return;
        }

        var re = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
        if(!email || !re.test(email)){
            layer.msg('请输入正确格式的邮箱！', {offset: height, icon: 2});
            $('#email').focus();
            return;
        }

        if(!describe){
            layer.msg('请输入描述！', {offset: height, icon: 2});
            $('#describe').focus();
            return;
        }

        $.ajax({
            url:'link/create',
            type:'post',
            data:{'name':name, 'url':url, 'email':email, 'describe':describe},
            success:function(re){
                if(re.code == 200){
                    layer.msg(re.msg, {offset: height, icon: 1});
                    setTimeout(function(){
                        window.location.href = '/';
                    },1000);
                }else{
                    layer.msg(re.msg, {offset: height, icon: 2});
                }
            }
        });
    });
})