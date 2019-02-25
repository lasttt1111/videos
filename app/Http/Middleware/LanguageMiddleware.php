<?php

namespace App\Http\Middleware;

use Closure;
use App;
use App\Models\Language;
class LanguageMiddleware
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
        $languageId = $request->cookie('language');
        if (!empty($languageId) && is_string($languageId)){
            $language = Language::find($languageId);
            if (!empty($language)){
                App::setLocale($languageId);
            } else {
                cookie()->forget('language');
            }
        }
        return $next($request);
    }
}
