<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class Suspended
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $suspended)
    {
        if (\Auth::user()->can($suspended . '-suspend')) {
            return $next($request);
        }
        \Auth::logout();
        return redirect()->route('please_verification');
//        return redirect()->route('verification.phone_number');
//        return response('Unauthorized.', 401);
    }

}
