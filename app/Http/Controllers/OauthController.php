<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Http\Controllers;

use Hash;
use App\Model\Oauth;
use Overtrue\LaravelSocialite\Socialite;
use Illuminate\Support\Facades\{Artisan, Auth, Session};

class OauthController extends Controller
{
    /**
     * Notes: 跳转github授权
     * Date: 2019/5/6 18:05
     * @return mixed
     */
    public function login()
    {
        return Socialite::driver('web_github')->redirect();
    }

    /**
     * Notes: 登录
     * Date: 2019/5/6 18:05
     * @return string
     */
    public function postLogin()
    {
        $github_user = Socialite::driver('web_github')->user();

        Oauth::firstOrCreate(['username' => $github_user->username], [
            'github_id' => $github_user->id,
            'username' => $github_user->username,
            'name' => $github_user->name,
            'email' => $github_user->email,
            'avatar' => $github_user->avatar,
            'github_url' => $github_user->original['html_url'],
            'blog' => $github_user->original['blog'],
            'company' => $github_user->original['company'],
            'original' => $github_user->original,
            'password' => Hash::make('123456'),
        ]);

        $data = [
            'email' => $github_user->email,
            'password' => '123456',
        ];

        if ($this->guard()->attempt($data)) {
            Artisan::call('create:avatar', [
                'image' => $github_user->avatar
            ]);
            $url = Session::get('url');

            return redirect($url);
        }
        dd('登录失败');
    }

    /**
     * 自定义认证驱动
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('oauth');
    }

    /**
     * Notes: 退出
     * Date: 2019/5/6 18:05
     * @return string
     */
    public function logout()
    {
        $this->guard()->logout();

        return ['code' => 200, 'msg' => '退出成功！'];
    }
}
