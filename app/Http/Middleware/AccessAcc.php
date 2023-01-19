<?php

namespace App\Http\Middleware;
use Closure;

class AccessAcc
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
        if (auth()->check() && $request->user()->role == 'acc'){
            return $next($request);
        }elseif (auth()->check() && $request->user()->role == 'admin'){
            return $next($request);
        }
        return response('Unauthorized.', 401);
    }
}
