<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


Auth::routes(['verify' => true]);


Route::get('/users/{user}/avatar', function (Request $request, User $user) {
    if (empty($user->avatar)) {
        abort(404);
    }

    $etag = '"' . md5($user->avatar) . '"';
    if ($request->header('If-None-Match') === $etag) {
        return response('', 304);
    }

    $filePath = 'avatars/' . $user->avatar;
    if (!Storage::disk('google')->exists($filePath)) {
        abort(404);
    }
    $file = Storage::disk('google')->get($filePath);

    return response($file, 200, [
        'Content-Type'  => 'image/webp',
        'Cache-Control' => 'no-cache, private',
        'ETag'          => $etag,
    ]);
})->name('users.avatar');

Route::get('/users/{user}/banner', function (Request $request, User $user) {
    if (empty($user->banner)) {
        abort(404);
    }

    $etag = '"' . md5($user->banner) . '"';
    if ($request->header('If-None-Match') === $etag) {
        return response('', 304);
    }

    $filePath = 'banners/' . $user->banner;
    if (!Storage::disk('google')->exists($filePath)) {
        abort(404);
    }
    $file = Storage::disk('google')->get($filePath);

    return response($file, 200, [
        'Content-Type'  => 'image/webp',
        'Cache-Control' => 'no-cache, private',
        'ETag'          => $etag,
    ]);
})->name('users.banner');

Route::get('/articles/{article}/thumbnail', function (Request $request, Article $article) {
    if (empty($article->thumbnail)) {
        abort(404);
    }

    $etag = '"' . md5($article->thumbnail) . '"';
    if ($request->header('If-None-Match') === $etag) {
        return response('', 304);
    }

    $filePath = 'thumbnails/' . $article->thumbnail;
    if (!Storage::disk('google')->exists($filePath)) {
        abort(404);
    }
    $file = Storage::disk('google')->get($filePath);

    return response($file, 200, [
        'Content-Type'  => 'image/webp',
        'Cache-Control' => 'no-cache, private',
        'ETag'          => $etag,
    ]);
})->name('articles.thumbnail');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [HomeController::class, 'detail'])->name('detail');

Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [LegalController::class, 'terms'])->name('terms');

// Author
Route::get('/@{slug}', [ProfileController::class, 'author'])->name('author.show');
Route::get('/@{slug}/articles', [ProfileController::class, 'authorArticle'])->name('author.article');

// Users
Route::prefix('/')->middleware('auth')->group(function() {
    Route::get('/articles', [ProfileController::class, 'profileArticle'])->name('profile.article');
    Route::resource('profile', ProfileController::class);
    Route::get('/profile/{slug}/edit', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::delete('/profile/delete-avatar/{id}', [ProfileController::class, 'deleteAvatar'])->name('delete-avatar');
    Route::delete('/profile/delete-banner/{id}', [ProfileController::class, 'deleteBanner'])->name('delete-banner');
    Route::get('/whitelists', [HomeController::class, 'whitelist'])->name('whitelist');
});

// Users Verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard', DashboardController::class);

    Route::post('/report-comment', [CommentReportController::class, 'reportComment'])->name('report.comment');
    Route::delete('/report-comment/delete/{id}', [CommentReportController::class, 'deleteComment'])->name('report.delete.comment');
    Route::delete('/report-comment/{id}', [CommentReportController::class, 'deleteCommentReport'])->name('report.delete');

    Route::post('/follow', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/follow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::delete('/follow/remove/{id}', [FollowController::class, 'removeFollower'])->name('removeFollower');
});


// Admin
Route::prefix('/')->middleware(['auth', 'isAdmin'])->group(function() {
    Route::resource('category', CategoryController::class);
    Route::resource('users', UserController::class);
});

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');
