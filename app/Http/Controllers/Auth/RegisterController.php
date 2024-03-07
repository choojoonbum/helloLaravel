<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Provider;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//use App\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegisterationForm()
    {
        return view('auth.register', ['providers' => Provider::cases()]);
    }

    public function register(RegisterUserRequest $request)
    {

        //$request->validate([
        //    'name' => 'required|max:255',
         //   'email' => 'required|email|unique:users|max:255',
        //    //'password' => [new PasswordRule()]
        //    'password' => [Password::defaults()]
        //]);

        $user = User::create([...$request->validated(),
            'password' => Hash::make($request->password)]);

        auth()->login($user);

        event(new Registered($user));
        return to_route('verification.notice');

/*
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validator = $validator->validate();
*/
    }

}
