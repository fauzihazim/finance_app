<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PocketController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/profile', [AuthController::class, 'profile'])->middleware('auth:api');
Route::post('/pockets', [PocketController::class, 'store'])->middleware('auth:api');
Route::post('/incomes', [IncomeController::class, 'store'])->middleware('auth:api');
Route::post('/expenses', [ExpenseController::class, 'store'])->middleware('auth:api');