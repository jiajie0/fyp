<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsStaff
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('staff')->check()) {
            // 如果未通过开发者守卫认证，则重定向到登录页面
            return redirect()->route('staff.login')->withErrors('Access denied.');
        }

        if (!(Auth::guard('staff')->user() instanceof \App\Models\Staff)) {
            // 如果通过认证但不是 Staff 模型，登出并拒绝访问
            Auth::guard('staff')->logout();
            return redirect()->route('staff.login')->withErrors('Access denied.');
        }

        return $next($request);
    }
}
