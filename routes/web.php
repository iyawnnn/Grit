<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth/google')->group(function () {
    Route::get('/login', [GoogleController::class, 'login'])->name('google.login');
    Route::get('/register', [GoogleController::class, 'register'])->name('google.register');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('google.callback');
});