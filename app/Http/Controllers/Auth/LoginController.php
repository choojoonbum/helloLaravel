<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (! auth()->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['failed' => _('auth.failed')]);
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
