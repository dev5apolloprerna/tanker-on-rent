<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $requested = $request->query('lang') ?? Session::get('lang', 'en');
        $locale = in_array($requested, ['en', 'gu']) ? $requested : 'en';

        App::setLocale($locale);
        Session::put('lang', $locale);

        // Localize date/time & diffForHumans
        Carbon::setLocale($locale);
        Date::setLocale($locale);

        return $next($request);
    }
}
