<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //三个判断
        //1、如果用户已登录
        //2、并且还未认证 Email
        //3、并且访问的不是 Email 验证相关 url 或者退出的 url
        if ($request->user() &&
            !$request->user()->hasVerifiedEmail() &&
            !$request->is('email/*', 'logout')) {

            //根据客户端返回对应内容
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified')
                : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
