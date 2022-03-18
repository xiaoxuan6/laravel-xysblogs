<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $check = Auth::guard('oauth')->check();
        if ($request->ajax()) {
            if (! $check) {
                return response()->json(['code' => 401, 'msg' => '请先登录!']);
            }
        } else {
            if (! $check) {
                return response()->view('error.error');
            }
        }

        return $next($request);
    }
}
