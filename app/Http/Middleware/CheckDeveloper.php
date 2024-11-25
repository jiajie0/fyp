<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckDeveloper
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user() instanceof \App\Models\Developer) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
