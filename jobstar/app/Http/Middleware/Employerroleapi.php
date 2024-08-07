<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Employerroleapi
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

		if (auth()->user()->role == 'company' && auth()->user()->status) {
            return $next($request);
        }
		else if(auth()->user()->status) {
			abort(response()->json(
            [
                'status' => '401',
                'message' => 'you don`t have permission to access',
            ], 401));
		}
		else if(auth()->user()->role == 'company'){
			abort(response()->json(
					[
						'status' => '401',
						'message' => 'User not activate yet',
					], 401));
		}
		else{
			abort(response()->json(
					[
						'status' => '401',
						'message' => 'User not activate yet',
					], 401));
		}
        //return $next($request);
    }
}
