<?php

namespace Tests\Feature\Http\Middleware;

use App\Http\Middleware\Locale;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    public function testLocaleChangeWithAcceptLanguageHeader()
    {
        $this->assertTrue(app()->isLocale('ko'));

        $localeMiddleware = app(Locale::class);

        $request = app(Request::class);
        $request->setLaravelSession(app(Session::class));
        $request->header('Accept-Language', 'en');

        $localeMiddleware->handle($request, function () {
            $this->assertTrue(app()->isLocale('en'));
            return response()->noContent();
        });
    }

    public function testLocaleChangeWithLangQueryString():void
    {
        $this->assertTrue(app()->isLocale('ko'));
        $localeMiddleware = app(Locale::class);

        $request = app(Request::class);
        $request->setLaravelSession(app(Session::class));

        $request->merge(['lang' => 'en']);

        $localeMiddleware->handle($request, function () {
            $this->assertTrue(app()->isLocale('en'));
            return response()->noContent();
        });
    }

}
