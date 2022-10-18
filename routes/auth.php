<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DosmaSessionController;

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:admin,dosen,mahasiswa')
    ->name('logout');

//registerasi mbkm
Route::get('/register_mahasiswa', [RegisteredUserController::class, 'create_mahasiswa'])
    ->middleware('guest')
    ->name('register');

Route::post('/register_mahasiswa', [RegisteredUserController::class, 'store_mahasiswa'])
    ->middleware('guest');

Route::get('/register_dosen', [RegisteredUserController::class, 'create_dosen'])
    ->middleware('guest')
    ->name('register_dosen');

Route::post('/register_dosen', [RegisteredUserController::class, 'store_dosen'])
    ->middleware('guest');

//login dosen
Route::get('/logoutd', [DosmaSessionController::class, 'logout_dosen'])
    ->middleware('auth:dosen');

//login mahasiswa
Route::get('/logoutm', [DosmaSessionController::class, 'logout_mahasiswa'])
    ->middleware('auth:mahasiswa');

Route::get('/logout_mahasiswa', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:mahasiswa')
    ->name('logout_mahasiswa');

Route::get('/logout_dosen', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:dosen')
    ->name('logout_dosen');
