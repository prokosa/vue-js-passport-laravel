<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckApiToken
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
		if(!empty(trim($request->input('authToken')))){
			
			$is_exists = User::where('id' , \Auth::guard('api')->id())->exists();
			if($is_exists){
				return $next($request);
			}
		}
		return response()->json('Invalid Token', 401);
	}
}
