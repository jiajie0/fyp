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
        // 检查用户是否是 Player 模型
        if (Auth::check() && Auth::user() instanceof \App\Models\Player) {
            return $next($request);
        }

        // 如果不是 Player，重定向到登录页面或其他页面
        return redirect()->route('player.login')->withErrors('Access denied.');
    }
}
