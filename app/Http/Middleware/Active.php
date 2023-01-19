<?php

namespace App\Http\Middleware;

use Closure;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$active)
    {
        if (\Auth::user()->can($active)) {
            return $next($request);
        }
        \Auth::logout();
        return redirect()->route('please_change_password');
//        return response('Unauthorized.', 401);
    }
}
