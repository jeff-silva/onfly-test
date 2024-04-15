<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/app/openapi', [Controllers\AppController::class, 'openapi']);

Route::apiResource('app_user', Controllers\AppUserController::class);
Route::apiResource('financial_expense', Controllers\FinancialExpenseController::class);
