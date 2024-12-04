<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;//？？？

class IsDeveloper
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('developer')->check()) {
            Log::info('Developer not authenticated. Redirecting to login.');
            return redirect()->route('developer.login')->withErrors('Access denied.');
        }

        if (!(Auth::guard('developer')->user() instanceof \App\Models\Developer)) {
            Log::warning('Authenticated user is not a Developer. Logging out.');
            Auth::guard('developer')->logout();
            return redirect()->route('developer.login')->withErrors('Access denied.');
        }

        Log::info('Developer authenticated. Proceeding to next middleware.');
        return $next($request);
    }
}
