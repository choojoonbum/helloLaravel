<?php

use Illuminate\Support\Facades\Route;

Route::get('/blogs', \App\Http\Controllers\Dashboard\BlogController::class)
    ->name('dashboard.blogs');
