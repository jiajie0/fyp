<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsPlayer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('player')->check()) {
            // 如果未通过开发者守卫认证，则重定向到登录页面
            return redirect()->route('player.login')->withErrors('Access denied.');
        }

        if (!(Auth::guard('player')->user() instanceof \App\Models\Player)) {
            // 如果通过认证但不是 Player 模型，登出并拒绝访问
            Auth::guard('player')->logout();
            return redirect()->route('player.login')->withErrors('Access denied.');
        }

        return $next($request);
    }
}
