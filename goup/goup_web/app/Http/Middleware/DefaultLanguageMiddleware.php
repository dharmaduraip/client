<?php

namespace App\Http\Middleware;

use Closure;

class DefaultLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('default_language') != null ) {
            \App::setLocale($request->session()->get('default_language'));
        }
        return $next($request);
    }
}
