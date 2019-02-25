<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Content;
use Auth;
class AdminMiddleware
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
        if (!Auth::check() || Auth::user()->permission > 2){
            return response()->make(Content::error(403));
        }
        \App\Helpers\Content::setMode('admin');
        return $next($request);
    }
}
