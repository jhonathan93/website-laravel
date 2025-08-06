<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate {

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response {
        if (empty($guards)) $guards = [null];

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) return $next($request);
        }

        return $request->expectsJson() ? response()->json(['message' => 'Unauthorized'], 401) : redirect()->guest(route('unauthorized'));
    }
}
