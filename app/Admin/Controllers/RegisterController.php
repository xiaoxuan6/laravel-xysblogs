<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Admin\Controllers;

use App\Lib\Sms;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Model\{AdminRoleUser, AdminUser};

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

        if (Redis::get('captcha_' . $username)) {
            return ['code' => __LINE__, 'msg' => '发送失败，30秒内只能发送一次！'];
        }

        $random = substr(base_convert(md5(uniqid(md5(microtime(true)), true)), 16, 10), 0, 6);
        $sms = new Sms();
        $re = $sms->sendSingle($phone, $random, '5');

        if (! $re) {
            return ['code' => __LINE__, 'msg' => '发送失败！'];
        }

        Redis::setex('captcha_' . $username, 300, $random);

        return ['code' => 200, 'msg' => '发送成功！'];
    }

    /*
    * 注册
    */
    public function postRegister(Request $request)
    {
        $data = $request->only(['username', 'password']);
        if (AdminUser::where('username', $data['username'])->first()) {
            return ['code' => __LINE__, 'msg' => '此用户已注册！'];
        }

        $captcha = $request->input('captcha');
        $random = Redis::get('captcha_' . $data['username']);
        if ($captcha != $random) {
            return ['code' => __LINE__, 'msg' => '验证码无效，请重试！'];
        }

        $data['pwd'] = $data['password'];
        $re = AdminUser::create($data);
        AdminRoleUser::create(['role_id' => 2, 'user_id' => $re->id]);

        return ['code' => 200, 'msg' => '注册成功！'];
    }
}
