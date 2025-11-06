<?php

use App\Http\Controllers\WebhookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect('/auth/google');
});

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

Route::post('/logout', function () {
    Auth::guard('web')->logout();
    session()->flush();
    session()->regenerate();
    return redirect('/');
});

Route::post('/webhook', [WebhookController::class, 'handle'])->withoutMiddleware(['web', 'auth']);

