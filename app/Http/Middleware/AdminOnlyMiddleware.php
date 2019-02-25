<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Helpers\Content;
class AdminOnlyMiddleware
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
        if (!Auth::check() || Auth::user()->permission > 1){
            return response()->make(Content::error(403));
        }
        return $next($request);
    }
}
