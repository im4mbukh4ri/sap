<?php

namespace App\Http\Middleware;

use Closure;

class Upline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$upline)
    {
        if (\Auth::user()->can($upline.'-access')) {
            return $next($request);
        }
        return redirect('https://smartinpays.com/logout',302);
    }
}
