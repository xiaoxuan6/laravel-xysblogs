<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\AdminRoleUser;
use App\Model\AdminUser;
use App\Model\GithubUser;
use App\Model\Oauth;
use Illuminate\Http\Request;
use Lib\Tool;
use Overtrue\LaravelSocialite\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{

    public function login()
    {
        return Socialite::driver('github')->redirect();
    }

    public function postLogin()
    {
        $github_user = Socialite::driver('github')->user();

        $user = AdminUser::firstOrCreate(['username' => $github_user->username],[
            'username' => $github_user->username,
            'password' => 'admin',
            'avatar' => $github_user->avatar,
            'pwd' => 'admin',
        ]);

        Oauth::firstOrCreate(['username' => $github_user->username],[
            'github_id' => $github_user->id,
            'username' => $github_user->username,
            'name' => $github_user->name,
            'email' => $github_user->email,
            'avatar' => $github_user->avatar,
            'github_url' => $github_user->original['html_url'],
            'blog' => $github_user->original['blog'],
            'company' => $github_user->original['company'],
            'original' => $github_user->original,
            'password' => \Hash::make('admin'),
        ]);

        // 赋值权限
        AdminRoleUser::firstOrCreate(['user_id' => $user->id],['role_id' => 2, 'user_id' => $user->id]);

        $data = [
            'username' => $user->username,
            'password' => 'admin',
        ];

        if (Auth::guard('admin')->attempt($data)) {
            admin_toastr(trans('admin.login_successful'));
            $avatar = Str::startsWith($user->avatar, ["http", "https"]) ? $user->avatar : NULL;
            session(['avatar' => $avatar]);

            return redirect(config('admin.route.prefix'));
        }else{
            dd('登录失败');
        }

    }

}
