<?php

namespace App\Admin\Controllers;

use App\Events\RegisterSendMail;
use App\Http\Controllers\Controller;
use App\Lib\Sms;
use App\Model\AdminRoleUser;
use App\Model\AdminUser;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Lib\Tool;

class RegisterController extends Controller
{

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index()
    {
        return view('admin.register');
    }

    /**
     * Notes: 发送邮件
     * Date: 2019/7/31 9:40
     * @param Request $request
     * @return array
     */
    public function sendSms(Request $request)
    {
        $phone = $request->input('phone');
        $username = $request->input('username');

        if(Redis::get('captcha_'.$username))
            return ['code' => __LINE__, 'msg' => '发送失败，30秒内只能发送一次！'];

        $random = substr(base_convert(md5(uniqid(md5(microtime(true)),true)), 16, 10), 0, 6);
        $sms = new Sms();
        $re = $sms->sendSingle($phone, $random, '5');

        if(!$re)
            return ['code' => __LINE__, 'msg' => '发送失败！'];
        else{
            Redis::setex('captcha_'.$username, 300, $random);
            return ['code' => 200, 'msg' => '发送成功！'];
        }
    }

    /*
	* 注册
    */
    public function postRegister(Request $request)
    {
        $data = $request->only(['username', 'password']);
        if(AdminUser::where('username', $data['username'])->first())
            return ['code' => __LINE__, 'msg' => '此用户已注册！'];

        $captcha = $request->input('captcha');
        $random = Redis::get('captcha_'.$data['username']);
        if($captcha != $random){
            return ['code' => __LINE__, 'msg' => '验证码无效，请重试！'];
        }

        $data['pwd'] = $data['password'];
        $re = AdminUser::create($data);
        AdminRoleUser::create(['role_id' => 2, 'user_id' => $re->id]);

        return ['code' => 200, 'msg' => '注册成功！'];
    }

}
