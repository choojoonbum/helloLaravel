<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\RequirePassword as Middleware;

class RequirePassword extends Middleware
{
    protected function shouldConfirmPassword($request, $passwordTimeoutSeconds = null)
    {
        return session()->socialiteMissingAll() && parent::shouldConfirmPassword($request, $passwordTimeoutSeconds);
    }

}
