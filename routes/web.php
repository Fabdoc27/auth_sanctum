<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// API Routes
Route::post( '/user-registration', [UserController::class, 'userRegistration'] );
Route::post( '/user-login', [UserController::class, 'userLogin'] );
Route::post( '/send-otp', [UserController::class, 'sendOtp'] );
Route::post( '/verify-otp', [UserController::class, 'verifyOtp'] );
Route::post( '/reset-password', [UserController::class, 'passwordReset'] )->middleware( 'auth:sanctum' );

Route::get( '/user-profile', [UserController::class, 'userProfile'] )->middleware( 'auth:sanctum' );
Route::post( '/user-update', [UserController::class, 'updateProfile'] )->middleware( 'auth:sanctum' );

Route::get( '/logout', [UserController::class, 'userLogout'] )->name( 'logout' )->middleware( 'auth:sanctum' );

// Page Routes
Route::view( '/', 'pages.home' )->name( 'home.page' );
Route::get( '/dashboard', [DashboardController::class, 'index'] )->name( 'dashboard.page' );
// ->middleware( 'auth:sanctum' );
Route::view( '/userLogin', 'pages.auth.login' )->name( 'login' );
Route::view( '/userRegistration', 'pages.auth.registration' )->name( 'registration.page' );
Route::view( '/sendOtp', 'pages.auth.sendOtp' )->name( 'otp.page' );
Route::view( '/verifyOtp', 'pages.auth.verifyOtp' );
Route::view( '/resetPassword', 'pages.auth.resetPassword' );
Route::view( '/userProfile', 'pages.dashboard.profile' )->name( 'profile.page' );