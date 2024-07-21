<?php

use App\Http\Controllers\Author;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [HomeController::class, 'detail'])->name('detail');

// Author
Route::get('/author/{slug}', [ProfileController::class, 'author'])->name('author.show');
Route::get('/article/{slug}', [ProfileController::class, 'authorArticle'])->name('author.article');

// Users
Route::prefix('/')->middleware('auth')->group(function() {
    Route::resource('dashboard', DashboardController::class);

    // profile
    Route::get('/article', [ProfileController::class, 'profileArticle'])->name('profile.article');
    Route::resource('profile', ProfileController::class);
    Route::get('/profile/{slug}/edit', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::delete('/profile/delete-avatar/{id}', [ProfileController::class, 'deleteAvatar'])->name('delete-avatar');
    Route::delete('/profile/delete-banner/{id}', [ProfileController::class, 'deleteBanner'])->name('delete-banner');
});


// Admin
Route::prefix('/')->middleware(['auth', 'isAdmin'])->group(function() {
    Route::resource('category', CategoryController::class);
    Route::resource('users', UserController::class);
});

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');