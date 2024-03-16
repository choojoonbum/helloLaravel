<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('blogs', \App\Http\Controllers\BlogController::class);

Route::controller(\App\Http\Controllers\SubscribeController::class)->group(function () {
    Route::post('subscribe', 'subscribe')->name('subscribe');
    Route::post('unsubscribe', 'unsubscribe')->name('unsubscribe');
});

// /blogs/{blog}/posts/create
Route::resource('blogs.posts', \App\Http\Controllers\PostController::class)->shallow();

Route::resource('posts.comments', \App\Http\Controllers\CommentController::class)
    ->shallow()
    ->only(['store', 'update', 'destroy']);

Route::resource('posts.attachments', \App\Http\Controllers\AttachmentController::class)
    ->shallow()
    ->only(['store', 'destroy']);
