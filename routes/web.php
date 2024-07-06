<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [HomeController::class, 'detail'])->name('detail');

Route::resource('dashboard', DashboardController::class)->middleware('auth');
