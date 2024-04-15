<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/app/openapi', [Controllers\AppController::class, 'openapi']);

Route::post('/auth/login', [Controllers\AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [Controllers\AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:api');
Route::post('/auth/refresh', [Controllers\AuthController::class, 'refresh'])->name('auth.refresh')->middleware('auth:api');
Route::post('/auth/user', [Controllers\AuthController::class, 'user'])->name('auth.user')->middleware('auth:api');

Route::apiResource('app_user', Controllers\AppUserController::class)->middleware('auth:api');
Route::apiResource('financial_expense', Controllers\FinancialExpenseController::class)->middleware('auth:api');
