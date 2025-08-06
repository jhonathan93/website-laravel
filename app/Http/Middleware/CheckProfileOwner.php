<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileOwner {

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response {

        if (auth()->user()->uuid !== $request->route('uuid')) {
            return $request->expectsJson() ? response()->json(['message' => 'Unauthorized'], 401) : redirect()->guest(route('unauthorized'));
        }

        return $next($request);
    }
}
