<?php

namespace Deepayan\LaraSpeak\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Deepayan\LaraSpeak\Facades\LaraSpeak;

class LaraSpeakMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            LaraSpeak::setAuthUserId(Auth::guard($guard)->user()->id);
        }

        return $next($request);
    }
}
