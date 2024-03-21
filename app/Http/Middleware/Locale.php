<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    private array $locales = ['ko', 'en'];

    private string $key = 'locale';

    private function locale(Request $request)
    {
        $locale = $request->getPreferredLanguage($this->locales);

        if ($request->has('lang') && $lang = $request->lang) {
            if (in_array($lang, $this->locales)) {
                $locale = $lang;
            }
        }

        return $locale;
    }

    public function handle(Request $request, Closure $next)
    {
        $locale = $this->locale($request);

        if ($request->session()->missing($this->key)) {
            $request->session()->put($this->key, $locale);
        }

        app()->setLocale($request->session()->get($this->key));

        return $next($request);
    }
}
