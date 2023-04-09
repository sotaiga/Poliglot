<?php

namespace Sotaiga\Poliglot;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;

class PoliglotMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() === 'GET') {
            $segment = $request->segment(1);

            if (!in_array($segment, config('poliglot.locales'))) {

                $segments = $request->segments();
                // $fallback = session('locale') ?: config('app.fallback_locale');
                $fallback = config('app.fallback_locale');
                $segments = Arr::prepend($segments, $fallback);

                return redirect()->to(implode('/', $segments));
            }

            // session(['locale' => $segment]);
            App::setLocale($segment);
        }

        return $next($request);
    }
}
