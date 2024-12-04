<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // 如果用户未通过认证
        if (!Auth::guard($guard)->check()) {
            // 根据路由或守卫类型跳转到对应登录页面
            if ($guard === 'developer') {
                return redirect()->route('developer.login');
            } elseif ($guard === 'staff') {
                return redirect()->route('staff.login');
            } elseif ($guard === 'player') {
                return redirect()->route('player.login');
            }

            // 默认跳转到主登录页面
            return redirect()->route('login');
        }

        return $next($request);
    }
}
