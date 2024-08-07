<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Useractiveapi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status) {
			return $next($request);
		} else {
			 abort(response()->json(
            [
                'status' => '401',
                'message' => 'User not activate yet',
            ], 401));

		}
    }
}
