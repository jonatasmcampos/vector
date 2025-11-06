<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('/entrar', [AuthenticationController::class, 'login'])->name('auth.login');
Route::post('/sair', [AuthenticationController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');
