<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Register\RegisterController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth');
Route::get('/register', [RegisterController::class, 'showRegistration'])->name('register');
Route::post('/register-user', [UserController::class, 'save'])->name('register-user');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'showHome'])->name('home');

    Route::middleware('profile.owner')->group(function () {
        Route::get('/profile/{uuid}', [ProfileController::class, 'showProfile'])->name('profile');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::view('/acesso-negado', 'blade.pages.auth.unauthorized')->name('unauthorized');

Route::fallback(fn () => response()->view('blade.pages.notFound.notFound', [], 404));
