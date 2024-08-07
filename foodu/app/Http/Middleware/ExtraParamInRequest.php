<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExtraParamInRequest
{
	public function handle($request, Closure $next)
	{
		$query = request()->query();
		$querycount = count($query);
		if ($querycount == 0) {
			$path = url()->current() . '/?' . time();
			return redirect()->to($path);
		}
		return $next($request);
	}
}