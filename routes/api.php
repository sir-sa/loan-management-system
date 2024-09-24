<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


// Protected Routes
Route::middleware(['jwt.auth'])->group(function () {
    Route::resource('loans',loanController::class);
    Route::post('loans/calculate', [LoanController::class, 'calculateLoan']);
    Route::patch('loans/status/{id}', [LoanController::class, 'updateStatus']);

    Route::post('logout', [AuthController::class, 'logout']);
});