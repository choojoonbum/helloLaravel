<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Auth\RegisterController::class)->group(function () {
    Route::get('/register', 'showRegisterationForm')->name('register');
    Route::post('/register', 'register');
});

