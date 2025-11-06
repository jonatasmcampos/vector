<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/entrar', [HomeController::class, 'login'])->name('view.login');
Route::post('/validar-login', [AuthenticationController::class, 'login'])->name('auth.login');
Route::get('/sair', [AuthenticationController::class, 'logout'])->name('auth.logout');

Route::get('/home', [HomeController::class, 'home'])->name('view.home');