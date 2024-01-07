<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// API Routes
// Route::post( '/user-registration', [UserController::class, 'userRegistration'] );
// Route::post( '/user-login', [UserController::class, 'userLogin'] );
// Route::post( '/send-otp', [UserController::class, 'sendOtp'] );
// Route::post( '/verify-otp', [UserController::class, 'verifyOtp'] );
// Route::post( '/reset-password', [UserController::class, 'passwordReset'] )->middleware( 'auth:sanctum' );

// Route::get( '/user-profile', [UserController::class, 'userProfile'] )->middleware( 'auth:sanctum' );
// Route::post( '/user-update', [UserController::class, 'updateProfile'] )->middleware( 'auth:sanctum' );

// Route::get( '/logout', [UserController::class, 'userLogout'] )->name( 'logout' )->middleware( 'auth:sanctum' );

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
Route::controller( UserController::class )->middleware( ['auth:sanctum'] )->group( function () {
    // API Routes
    Route::post( '/user-registration', 'userRegistration' )->withoutMiddleware( 'auth:sanctum' );
    Route::post( '/user-login', 'userLogin' )->withoutMiddleware( 'auth:sanctum' );
    Route::post( '/send-otp', 'sendOtp' )->withoutMiddleware( 'auth:sanctum' );
    Route::post( '/verify-otp', 'verifyOtp' )->withoutMiddleware( 'auth:sanctum' );

    Route::post( '/reset-password', 'passwordReset' );
    Route::get( '/user-profile', 'userProfile' );
    Route::post( '/user-update', 'updateProfile' );
    Route::get( '/logout', 'userLogout' )->name( 'logout' );
} );