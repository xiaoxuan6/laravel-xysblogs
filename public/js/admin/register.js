$(function () {
    $('.send').click(function () {
        var username = $('input[name="username"]').val();
        if(!username){
            // layer.msg('用户名不能为空！');
            layer.msg('用户名不能为空！');
            $('input[name="username"]').focus();
            return false;
        }

        var phone = $('input[name="phone"]').val();
        var myreg= /^[1][3,4,5,7,8][0-9]{9}$/;

        if(!phone || !myreg.test(phone)){
            // layer.msg('请输入正确格式手机号！');
            layer.msg('请输入正确格式手机号！');
            $('input[name="phone"]').focus();
            return false;
        }
        $.ajax({
            url : "/admins/auth/sms",
            type: 'post',
            data: {'phone':phone, 'username':username},
            success:function (re) {
                layer.msg(re.msg);
            }
        });
    });
    $('.save').click(function(){
        var username = $('input[name="username"]').val();
        if(!username){
            layer.msg('用户名不能为空！');
            $('input[name="username"]').focus();
            return false;
        }
        var password = $('input[name="password"]').val();
        if(!password || password.length < 6){
            layer.msg('请输入密码，最少6位数！');
            $('input[name="password"]').focus();
            return false;
        }
        var confirm_password = $('input[name="confirm_password"]').val();
        if(!confirm_password || confirm_password != password){
            layer.msg('确认密码有误，请重新输入！');
            $('input[name="confirm_password"]').focus();
            return false;
        }
        var captcha = $('input[name="captcha"]').val();
        if(!captcha){
            layer.msg('请输入验证码！');
            $('input[name="captcha"]').focus();
            return false;
        }
        $.ajax({
            url: "/admins/auth/register",
            type: 'post',
            data: {'username':username, "name":name, 'password':password, 'captcha':captcha},
            enctype: 'multipart/form-data',
            success:function (re) {
                // layer.msg(JSON.stringify(re));
                if(re.code == 200){
                    layer.msg(re.msg);
                    setTimeout(function () {
                        window.location.href = "/admins/auth/login";
                    },1000);
                }else
                    layer.msg(re.msg);
            }
        });
    });
})