<?php

namespace App\Http\Middleware;

use Closure;

class ApiLogRequestResponse
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
        $log = new \App\ApiLog();
        $log->domain = $request->root();
        $log->path = $request->path();
        $log->method = $request->method();
        $log->ip_request = $request->ip();
        $log->header_request = json_encode($request->header());
        $log->request = json_encode($request->all());
        if ($request->hasHeader('authorization')) {
            $token = explode(' ', $request->header('authorization'));
            $log->token = $token[1];
        }elseif ($request->has('access_token')) {
            $log->token = $request->access_token;
        }
        if($request->hasHeader('device_id')){
            $log->device_id = $request->header('device_id');
        }
        $log->save();
        $request->log_id = $log->id;
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $log = \App\ApiLog::find($request->log_id);
        if($log){ // if not null
            $log->http_code = $response->status();
            $log->response = $response->content();
            $log->save();
        }
    }
}
