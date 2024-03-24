<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Provider;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['providers' => Provider::cases()]);
    }

    public function login(LoginRequest $request)
    {
        if (! auth()->attempt($request->validated(), $request->boolean('remember'))) {
            return back()->withErrors(['failed' => _('auth.failed')]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Successfully logged in']);
        }

        return redirect()->intended();
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
