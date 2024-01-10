<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Page Routes
Route::view( '/', 'pages.home' )->name( 'home.page' );
Route::get( '/dashboard', [DashboardController::class, 'index'] )->name( 'dashboard.page' );
Route::view( '/userLogin', 'pages.auth.login' )->name( 'login' );
Route::view( '/userRegistration', 'pages.auth.registration' )->name( 'registration.page' );
Route::view( '/sendOtp', 'pages.auth.sendOtp' )->name( 'otp.page' );
Route::view( '/verifyOtp', 'pages.auth.verifyOtp' );
Route::view( '/resetPassword', 'pages.auth.resetPassword' );
Route::view( '/userProfile', 'pages.dashboard.profile' )->name( 'profile.page' );

// Middleware Group
Route::middleware( ['auth:sanctum'] )->group( function () {
    // API Routes
    Route::post( '/user-registration', [UserController::class, 'userRegistration'] )->withoutMiddleware( 'auth:sanctum' );
    Route::post( '/user-login', [UserController::class, 'userLogin'] )->withoutMiddleware( 'auth:sanctum' );
    Route::post( '/send-otp', [UserController::class, 'sendOtp'] )->withoutMiddleware( 'auth:sanctum' );
    Route::post( '/verify-otp', [UserController::class, 'verifyOtp'] )->withoutMiddleware( 'auth:sanctum' );

    Route::post( '/reset-password', [UserController::class, 'passwordReset'] );
    Route::get( '/user-profile', [UserController::class, 'userProfile'] );
    Route::post( '/user-update', [UserController::class, 'updateProfile'] );
    Route::get( '/logout', [UserController::class, 'userLogout'] )->name( 'logout' );
} );