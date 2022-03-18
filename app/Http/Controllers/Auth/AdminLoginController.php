<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Http\Controllers\Auth;

use Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;
use App\Model\{AdminRoleUser, AdminUser, GithubUser, Oauth};

class AdminLoginController extends Controller
{
    public function login()
    {
        return Socialite::driver('github')->redirect();
    }

    public function postLogin()
    {
        $github_user = Socialite::driver('github')->user();

        $user = AdminUser::firstOrCreate(['username' => $github_user->username], [
            'username' => $github_user->username,
            'password' => 'admin',
            'avatar' => $github_user->avatar,
            'pwd' => 'admin',
        ]);

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
            'password' => Hash::make('admin'),
        ]);

        // 赋值权限
        AdminRoleUser::firstOrCreate(['user_id' => $user->id], ['role_id' => 2, 'user_id' => $user->id]);

        $data = [
            'username' => $user->username,
            'password' => 'admin',
        ];

        if (Auth::guard('admin')->attempt($data)) {
            admin_toastr(trans('admin.login_successful'));
            $avatar = Str::startsWith($user->avatar, ['http', 'https']) ? $user->avatar : null;
            session(['avatar' => $avatar]);

            return redirect(config('admin.route.prefix'));
        }
        dd('登录失败');
    }
}
