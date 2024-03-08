<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordConfirmRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordConfirmController extends Controller
{
    public function showPasswordConfirmationForm()
    {
        return view('auth.confirm-password');
    }

    public function confirm(PasswordConfirmRequest $request)
    {
        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => __('auth.password')]);
        }

        $request->session()->passwordConfirmed();
        return redirect()->intended();
    }
}
