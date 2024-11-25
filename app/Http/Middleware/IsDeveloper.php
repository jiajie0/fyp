<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsDeveloper
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('developer')->check()) {
            // 如果未通过开发者守卫认证，则重定向到登录页面
            return redirect()->route('developer.login')->withErrors('Access denied.');
        }

        if (!(Auth::guard('developer')->user() instanceof \App\Models\Developer)) {
            // 如果通过认证但不是 Developer 模型，登出并拒绝访问
            Auth::guard('developer')->logout();
            return redirect()->route('developer.login')->withErrors('Access denied.');
        }

        return $next($request);
    }
}
