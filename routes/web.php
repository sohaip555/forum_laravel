<?php

use App\Http\Controllers\CommentController;
//use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Support\PostFixtures;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::Resource('posts', PostController::class)->shallow()->only(['store', 'create']);
    Route::Resource('posts.comments', CommentController::class)->shallow()->only(['store', 'update', 'destroy']);
//    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
//    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
//    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

});

Route::get('posts/{topic?}', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}/{slug}', [PostController::class, 'show'])->name('posts.show');
//Route::Resource('posts', PostController::class)->shallow()->only(['index']);

